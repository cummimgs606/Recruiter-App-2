<?php
    echo    '<div class="row theme-grey">

                <div class="column-12">

                    <div class="bar">

                        '.$header_find_a_consultant.'

                    </div>

                </div>

            </div>';

        echo '<div class="row theme-white">
            
            <div class="panel column-6 theme-white">
                '
                .anchor('consultant/find_by_brand',                     $header_find_brand).'</p>'
                .anchor('consultant/find_by_id',                        $header_find_id).'</p>'
                .anchor('consultant/find_by_office',                    $header_find_office).'</p>'
                .anchor('consultant/find_by_practice',                  $header_find_practice).'</p>'
                .anchor('consultant/find_by_search',                    $header_find_search).'</p>'
                .anchor('consultant/find_by_team',                      $header_find_team).'</p>'
                .anchor('consultant/find_by_brand_country_paractice',   $header_find_country_practice).'</p>'.
                '
            </div>

        </div>';

?>
        
        
        
        
      