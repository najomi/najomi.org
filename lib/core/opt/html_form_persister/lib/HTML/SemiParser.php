<?php
/**
 * HTML_SemiParser: selective fast-and-dirty tags processing via callbacks.
 * (C) 2005 Dmitry Koterov, http://forum.dklab.ru/users/DmitryKoterov/
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * See http://www.gnu.org/copyleft/lesser.html
 *
 * The main idea is to assign callbacks for specified tags and containers
 * (e.g. <a>, <input>, <img> etc.) and run them for various HTML text
 * to get result of substitutions. It could be used, for example, to
 * "on the fly" replacement in the following tasks:
 * - insert 'value="..."' attributes to <input> tags based on $_REQUEST.
 *   See HTML_FormPersister class.
 * - replace 'href='...'" in links to make "transparent" human-readable
 *   URLs for ready scripts.
 * - automatically insert "width=... height=..." into <img> tags.
 *
 * You may use this class in three different modes.
 *
 * 1. Create separate instance and then call addTag(), addContainer() etc.
 *    for it adding callback functions for each needed element:
 *
 *      $parser = new HTML_SemiParser();
 *      $parser->addTag('a', 'handleLingsCallback');
 *      echo $parser->process($text);
 *      ...
 *      function handleLingsCallback($parsedTagAttributes) { ... }
 *
 * 2. Create subclass of HTML_SemiParser and define methods with names
 *    tag_*(), container_*() and re_*() in it.
 *
 *      class HTML_ImageWidthHeightAutosetter extends HTML_SemiParser {
 *        function tag_img($parsedTagAttributes) { ... }
 *      }
 *      $parser = new HTML_ImageWidthHeightAutosetter();
 *      echo $parser->process($text);
 *
 * 3. Add all handlers from any HTML_SemiParser object to another object:
 *
 *      $parserA = new HTML_LinkParser();
 *      $parserB = new HTML_ImageWidthHeightAutosetter();
 *      $parserA->addObject($parserB);
 *
 * If two callback handlers want to use the same tag (for example, we may
 * have two callbacks for <img> tag: first - for automatically setting width
 * and height attributes, and second - to replace images by their icons),
 * handlers are called one by one, like in conveyer.
 *
 * Order of substitution:
 * - direct regular expressions;
 * - tags;
 * - containers.
 *
 * @author Dmitry Koterov
 * @version 1.108
 * @package HTML
 */
class HTML_SemiParser
{
    /**
     * Handled tags, containers and regiular expressions.
     */
    var $sp_tags = array(); // array(tagName => list( h1, h2, ...), ...)
    var $sp_cons = array();
    var $sp_res = array();
    var $sp_precachers = array();
    var $sp_postprocs = array();
    var $sp_preprocs = array();
    
    /**
     * Functions for quoting/dequoting.
     */
    var $sp_quoteHandler = null;
    var $sp_dequoteHandler = null;

    /**
     * Object-callback name prefixes.
     */
    var $sp_preTag = "tag_";        // for tag gandlers
    var $sp_preCon = "container_";  // for container handlers
    var $sp_preRe  = "re_";         // for REs

    /**
     * Characters inside tag RE (between < and >).
     */
    var $sp_reTagIn = '(?>(?xs) (?> [^>"\']+ | " [^"]* " | \' [^\']* \' )* )';
    
    /**
     * Containers, whose bodies are not parsed by the library.
     */
    var $sp_IGNORED = array('script', 'iframe', 'textarea', 'select', 'title');
    var $sp_SKIP_IGNORED = true; 

    /**
     * Local temp variables.
     */
    var $sp_replaceHash;     // unique hash to replace all the tags

    /**
     * HTML_SemiParser constructor.
     */
    function HTML_SemiParser()
    {
        // Add child handlers.
        $this->sp_selfAdd = true;
        $this->addObject($this);
        unset($this->sp_selfAdd);
        
        // Initialize quoters.
        $this->sp_quoteHandler = 'htmlspecialchars';
        $this->sp_dequoteHandler = array(get_class($this), '_unhtmlspecialchars');

        // Generate unique hash.
        static $num = 0;
        $uniq = md5(microtime() . ' ' . ++$num . ' ' . getmypid());
        $this->sp_replaceHash = $uniq;
    }

    /**
     * Add new tag handler for future processing.
     *
     * Handler is a callback which is will be for each tag found in the
     * parsed document. This callback could be used to replace tag. Here is
     * the prototype:
     *
     * mixed handler(array $attributes)
     *
     * Callback get 1 parameter - parset tag attribute array.
     * The following types instead of "mixed" is supported:
     *
     * - bool or NULL  If handler returns FALSE or NULL, source tag is
     *                 not modified.
     * - string        Returning value is used t replace original tag.
     * - array         Returning value is treated as associative array of
     *                 tag attributes. Array also contains two special
     *                 elements:
     *                 - "_tagName": name of tag;
     *                 - "_text":    string representation of tag body
     *                               (for containers only, see below).
     *                               String representation of tag will be
     *                               reconstructed automatically by that array.
     *
     * @param string   $tagName  Name of tag to handle. E.g., "a", "img" etc.
     * @param callback $handler  Callback which will be called on for found tag.
     * @return void
     */
    function addTag($tagName, $handler, $atFront=false)
    {
        $tagName = strtolower($tagName);
        if (!isSet($this->sp_tags[$tagName])) $this->sp_tags[$tagName] = array();
        if (!$atFront) array_push($this->sp_tags[$tagName], $handler);
        else array_unshift($this->sp_tags[$tagName], $handler);
        // echo "Tag added: $tagName<br>\n";
    }

    /**
     * Add the container handler.
     *
     * Containers are processed just like simple tags (see addTag()), but they also have
     * bodies saved in "_text" attribute.
     *
     * @param string    $contName   Name of container to search.
     * @param callback  $handler    Call this function to replace.
     * @return void
     */
    function addContainer($tagName, $handler, $atFront=false)
    {
        $tagName = strtolower($tagName);
        if (!isSet($this->sp_cons[$tagName])) $this->sp_cons[$tagName] = array();
        if (!$atFront) array_push($this->sp_cons[$tagName], $handler);
        else array_unshift($this->sp_cons[$tagName], $handler);
        // echo "Container added: $tagName\n";
    }

    /**
     * Add regular expression replacer.
     *
     * Use callback with one parameter: RE matched pockets.
     *
     * @param string    $re       Regular Expression to search for.
     * @param callback  $handler  Call this function to replace.
     * @return void
     */
    function addReplace($re, $handler, $atFront=false)
    {
        if (!isSet($this->sp_res[$re])) $this->sp_res[$re] = array();
        if (!$atFront) array_push($this->sp_res[$re], $handler);
        else array_unshift($this->sp_res[$re], $handler);
    }

    /**
     * Add all the callback methods from $obj.
     *
     * Types of handlers (tag, container or RE) depend on method name prefix:
     * see $sp_pre* properties above.
     *
     * @param object  $obj  Use this object methods as callbacks.
     * @return void
     */
    function addObject(&$obj, $noPrecache=false, $atFront=false)
    {
        // Search for all the derieved handlers.
        foreach (get_class_methods($obj) as $m) {
            if (strpos($m, $this->sp_preTag) === 0) {
                $this->addTag(substr($m, strlen($this->sp_preTag)), array(&$obj, $m), $atFront);
            }
            if (strpos($m, $this->sp_preCon) === 0) {
                $this->addContainer(substr($m, strlen($this->sp_preCon)), array(&$obj, $m), $atFront);
            }
            if (strpos($m, $this->sp_preRe) === 0) {
                $meth = substr($m, strlen($this->sp_preRe));
                $re = call_user_func(array(&$obj, $m));
                if ($re !== false && $re !== null) {
                    $this->addReplace($re, array(&$obj, $meth), $atFront);
                }
            }
        }
        // Add object precacher & post-processors if present.
        if (!isset($this->sp_selfAdd)) {
            foreach (array('precacheTags'=>'sp_precachers', 'postprocText'=>'sp_postprocs', 'preprocText'=>'sp_preprocs') as $pname=>$var) {
                if (method_exists($obj, $pname)) {
                    if (!$atFront) array_push($this->$var, array(&$obj, $pname));
                    else array_unshift($this->$var, array(&$obj, $pname));
                }
            }
        }
    }
    
    /**
     * Quote HTML entities. 
     * You may override this method or set $this->sp_quoteHandler property.
     * 
     * @param string $str String to quote.
     * @return string Quoted string.
     */
    function quoteHandler($value)
    {
        return call_user_func($this->sp_quoteHandler, $value);
    }
    
    /**
     * Dequote HTML entities. 
     * You may override this method or set $this->sp_dequoteHandler property.
     * 
     * @param string $str String to dequote.
     * @return string Dequoted string.
     */
    function dequoteHandler($value)
    {
        return call_user_func($this->sp_dequoteHandler, $value);
    }
    
    /**
     * Reverse function for htmlspecialchars(). 
     */
    function _unhtmlspecialchars($value)
    {
        // Generate entity translation table (only once!).
        static $sp_trans = null;
        if (!$sp_trans) {
            $sp_trans = array_flip(get_html_translation_table(HTML_SPECIALCHARS));
            $sp_trans['&#039;'] = "'"; // manually translate apostroph for FireFox
        }
        return strtr($value, $sp_trans);
    }

    /**
     * Process HTML string and call all the callbacks for it.
     *
     * @param string  $buf  HTML text.
     * @return Text after all the replaces.
     */
    function process($buf)
    {
        $reTagIn = $this->sp_reTagIn;
        
        // Preprocess the text.
        $new = $this->preprocText($buf);
        if ($new !== null) $buf = $new;
        
        // Remove ignored container bodies from the string.
        $this->sp_ignored = array();
        if ($this->sp_SKIP_IGNORED) {
            $reIgnoredNames = join("|", $this->sp_IGNORED);
            $reIgnored = "{(<($reIgnoredNames) (?> \s+ $reTagIn)? >) (.*?) (</\\2>)}six";
            // Note that we MUST increase backtrack_limit, else error
            // PREG_BACKTRACK_LIMIT_ERROR will be generated on large SELECTs
            // (see preg_last_error() in PHP5). 
            $oldLimit = ini_get('pcre.backtrack_limit');
            ini_set('pcre.backtrack_limit', 1024 * 1024 * 10);
            $buf = preg_replace_callback(
                $reIgnored,
                array(&$this, "_callbackIgnored2Hash"),
                $buf
            );
            ini_set('pcre.backtrack_limit', $oldLimit);
        }
        $sp_ignored = array($this->sp_ignored, array_keys($this->sp_ignored), array_values($this->sp_ignored));
        unset($this->sp_ignored);

        // Replace custom REs.
        if ($this->sp_res) {
            foreach ($this->sp_res as $re => $handlers) {
                foreach ($handlers as $h) {
                    $buf = preg_replace_callback($re, $h, $buf);
                }
            }
        }

        // Replace tags and containers.
        $hashlen = strlen($this->sp_replaceHash) + 10;
        $reTagNames = join("|", array_keys($this->sp_tags));
        $reConNames = join("|", array_keys($this->sp_cons));
        $infos = array();
        // (? >...) [without space] is much faster than (?:...) in this case.
        if ($this->sp_tags) 
            $infos["sp_tags"] = "/( <($reTagNames) (?> (\s+ $reTagIn) )? > () )/isx";
        if ($this->sp_cons) 
            $infos["sp_cons"] = "/( <($reConNames) (?> (\s+ $reTagIn) )? > (.*?) (?: <\\/ \\2 \\s* > | \$ ) )/isx";
        foreach ($infos as $src => $re) {
            // Split buffer into tags.
            $chunks = preg_split($re, $buf, 0, PREG_SPLIT_DELIM_CAPTURE);
            $textParts = array($chunks[0]); // unparsed text parts
            $foundTags = array();           // found tags
            for ($i=1, $n=count($chunks); $i<$n; $i+=5) {
                // $i points to sequential tag (or container) subchain.
                $tOrig    = $chunks[$i];     // - original tag text
                $tName    = $chunks[$i+1];   // - tag name
                $tAttr    = $chunks[$i+2];   // - tag attributes
                $tBody    = $chunks[$i+3];   // - container body
                $tFollow  = $chunks[$i+4];   // - following unparsed text block

                // Add tag to array for precaching.
                $tag = array(); 
                $this->parseAttrib($tAttr, $tag);
                $tag['_orig'] = $tOrig;
                $tag['_tagName'] = $tName;
                if ($src == "sp_cons") {
                    if (strlen($tBody) < $hashlen && isset($sp_ignored[0][$tBody])) {
                        // Maybe it is temporarily removed content - place back!
                        // Fast solution working in most cases (key-based hash lookup
                        // is much faster than str_replace() below).
                        $tBody = $sp_ignored[0][$tBody];
                    } else {
                        // We must pass unmangled content to container processors!
                        $tBody = str_replace($sp_ignored[1], $sp_ignored[2], $tBody);
                    }
                    $tag['_text'] = $tBody;
                } else if (substr($tAttr, -1) == '/') {
                    $tag['_text'] = null;
                }
                $foundTags[] = $tag;
                $textParts[] = $tFollow;
            }
            
            // Save original tags.
            $origTags = $foundTags;

            // Precache (possibly modifying) all the found tags (if needed).
            $this->precacheTags($foundTags);
            
            // Process all found tags and join the buffer.
            $buf = $textParts[0];
            for ($i=0, $n=count($foundTags); $i<$n; $i++) {
                $tag = $this->_runHandlersForTag($foundTags[$i]);
                if (!is_array($tag)) {
                    // String representation.
                    $buf .= $tag;
                } else {
                    $left  = isset($tag['_left'])?  $tag['_left']  : ""; unset($tag['_left']);
                    $right = isset($tag['_right'])? $tag['_right'] : ""; unset($tag['_right']);
                    if (!isset($tag['_orig']) || $tag !== $origTags[$i]) {
                        // Build the tag back if it is changed.
                        $text = $this->makeTag($tag);
                    } else {
                        // Else - use original tag string.
                        // We use this algorythm because of non-unicode tag parsing mode:
                        // e.g. entity &nbsp; in tag attributes is replaced by &amp;nbsp;
                        // in makeTag(), but if the tag is not modified at all, we do
                        // not care and do not call makeTag() at all saving original &nbsp;.
                        $text = $tag['_orig'];
                    }
                    $buf .= $left . $text . $right;
                }
                $buf .= $textParts[$i+1];
            }
        }

        // Return temporarily removed containers back.
        $buf = str_replace($sp_ignored[1], $sp_ignored[2], $buf);
        
        $new = $this->postprocText($buf);
        if ($new !== null) $buf = $new;
            
        return $buf;
    }

    /**
     * Recreate the tag or container by its parsed attributes.
     *
     * If $attr[_text] is present, make container.
     *
     * @param array  $attr  Attributes of tag. These attributes could
     *                      include two special attributes:
     *                      '_text':    tag is a container with body.
     *                                  If null - <tag ... />.
     *                                  If not present - <tag ...>.
     *                      '_tagName': name of this tag.
     *                      '_orig':    ignored (internal usage).
     *
     * @return  HTML-strict representation of tag or container.
     */
    function makeTag($attr)
    {
        // Join & return tag.
        $s = "";
        foreach($attr as $k => $v) {
            if ($k == "_text" || $k == "_tagName" || $k == "_orig") continue;
            $s .= " " . $k;
            if ($v !== null) $s .= '="' . $this->quoteHandler($v) . '"';
        }
        if (!@$attr['_tagName']) $attr['_tagName'] = "???";

        if (!array_key_exists('_text', $attr)) { // do not use isset()! 
            $tag = "<{$attr['_tagName']}{$s}>";
        } else if ($attr['_text'] === null) { // null
            $tag = "<{$attr['_tagName']}{$s} />";
        } else {
            $tag = "<{$attr['_tagName']}{$s}>{$attr['_text']}</{$attr['_tagName']}>";
        }
        return $tag;
    }

    /**
     * Virtual user-defined client precache functions.
     *
     * This function is called after all tags and containers are
     * found in HTML text, but BEFORE any replaces. It could work with
     * $foundTags to process all found data at once (for
     * faster replacing later). E.g., if callbacks use MySQL, it is
     * much more faster to perform one SQL-query with big IN() clause
     * than a lot of simple SQL querise with their own get_result()
     * calls.
     *
     * @return void
     */
    function precacheTags(&$foundTags)
    {
        foreach ($this->sp_precachers as $pk) {
            // call_user_func() does not support &-parameters 
            // while allow_call_time_pass_reference=false
            call_user_func_array($pk, array(&$foundTags));
        }
    }

    /**
     * Called after all the tags ane containers are processed,
     * but before HTML is sent to caller context.
     */
    function preprocText($buf)
    {
        foreach ($this->sp_preprocs as $pk) {
            // call_user_func() does not support &-parameters 
            // while allow_call_time_pass_reference=false
            $new = call_user_func($pk, $buf);
            if ($new !== null) $buf = $new;
        }
        return $buf;
    }
    
    /**
     * Called after all the tags ane containers are processed,
     * but before HTML is sent to caller context.
     */
    function postprocText($buf)
    {
        foreach ($this->sp_postprocs as $pk) {
            // call_user_func() does not support &-parameters 
            // while allow_call_time_pass_reference=false
            $new = call_user_func($pk, $buf);
            if ($new !== null) $buf = $new;
        }
        return $buf;
    }
    
    /**
     * Replace found ignored container body by hash value.
     * 
     * Container's open and close tags are NOT modified!
     * Later hash value will be replaced back to original text.
     */
    function _callbackIgnored2Hash($m)
    {
        static $counter = 0;
        $hash = $this->sp_replaceHash . ++$counter . "|"; 
        // DO NOT use chr(0) here!!!
        $this->sp_ignored[$hash] = $m[3];
        return $m[1] . $hash . $m[4];
    }
    
    /**
     * Process the tag.
     *
     * @param array $attr     Parsed tag.
     * @return                Attributes of processed tag.
     */
    function _runHandlersForTag($tag)
    {
        // Processing tag or container?..
        $tagName = strtolower($tag['_tagName']);
        if (isset($tag['_text'])) {
            // If $tag['_text'] === null, it is NOT a container but self-closed tag!
            // And isset(null) returns false, as we need, and we do not get here.
            $handlers = $this->sp_cons[$tagName];
        } else {
            $handlers = $this->sp_tags[$tagName];
        }
        // Use all handlers right-to-left.
        for ($i = count($handlers)-1; $i >= 0; $i--) {
            $h = $handlers[$i];
            $result = call_user_func($h, $tag, $tagName);
            // If returned false, tag is not changed.
            if ($result !== false && $result !== null) {
                // If the string is returned, stop processing now.
                if (!is_array($result)) return $result;
                // Else continue.
                $tag = $result;
            }
        }
        return $tag;
    }

    /**
     * Parse the attribute string: "a1=v1 a2=v2 ..." of the tag.
     *
     * @param  $body     Tag body between < and >.
     * @param  &$attr    Resulting Array of tag attributes
     * @return void.
     */
    function parseAttrib($body, &$attr)
    {
        $preg = '/([-\w:]+) \s* ( = \s* (?> ("[^"]*" | \'[^\']*\' | \S*) ) )?/sx';
        $regs = null;
        preg_match_all($preg, $body, $regs);
        $names = $regs[1];
        $checks = $regs[2];
        $values = $regs[3];
        $attr = array();
        for ($i = 0, $c = count($names); $i < $c; $i++) {
            $name = strtolower($names[$i]);
            if (!@$checks[$i]) {
                $value = $name;
            } else {
                $value = $values[$i];
                if ($value[0] == '"' || $value[0] == "'") {
                    $value = substr($value, 1, -1);
                }
            }
            if (strpos($value, '&') !== false)
                $value = $this->dequoteHandler($value);
            $attr[$name] = $value;
        }
    }
}
?>