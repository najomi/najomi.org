<?php

echo bu::view('flash_block',
              array('error'=>bu::flash('error'),
                    'success'=>bu::flash('success'),
                    'notice'=>bu::flash('notice')));


