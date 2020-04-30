<?php

namespace Assets;

/**
 * 
 *
 * @package WordPress
 
 * @since 1.0.0
 */

if ( ! class_exists( 'Assets\Image' ) ) {

    class Image {

        /**
         * Filter attachment for archive pages
         * Change src and srcset to data-src and data-srcset, and add class 'lazyload'
         * @param $attributes
         * @return mixed
         */
        public static function filterGetAttachmentImgAttributes($attributes)
        {

            if (is_array($attributes) && count($attributes) > 0) {

                $attributes['class'] .= ' lazyload';
                
                if (isset($attributes['src'])) {
                    $attributes['data-src'] = $attributes['src'];
                    unset($attributes['src']); //could add default small image or a base64 encoded small image here
                }
                if (isset($attributes['srcset'])) {
                    $attributes['data-srcset'] = $attributes['srcset'];
                    unset($attributes['srcset']);
                }

                return $attributes;
            }

            return $attributes;
        }

        /**
         * Modify the content
         * Search after Img Element to alter their markup 
         * to add support for lazyloading
         * 
         * 
         * @return String
         */
        public static function filterTheContent($the_content)
        {
            $the_content = mb_convert_encoding($the_content, 'HTML-ENTITIES', "UTF-8");
            // Parse the string html Content
            libxml_use_internal_errors(true);

            
            $dom = new \DOMDocument();
            $dom->loadHTML($the_content);
            // $post->loadHTML($encoded_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            // Iterate each img tag
            foreach( $dom->getElementsByTagName('img') as $nodeImg ) {
                self::lazyImage($nodeImg);    
            }
            
            // Apply Lazy IFrame
            foreach ($dom->getElementsByTagName('iframe') as $nodeIframe) { 
                self::lazyIframe( $nodeIframe );
            }


                // if( $img->parentNode->tagName == 'noscript' ) continue;

                // $clone = $img->cloneNode();

                // $no_script = $post->createElement('noscript');
                // $no_script->appendChild($clone);
                // $img->parentNode->insertBefore($no_script, $img);
            // }

            // $the_edited_content = $post->saveHTML();
            // return utf8_decode($the_edited_content);

            $newHtml = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML()));
            return $newHtml;
        }

        public static function lazyImage($nodeImg, $class = 'lazyload')
        {
            $parentClass = $nodeImg->parentNode->getAttribute('class');
            if( strpos($parentClass, 'slide-bg') !== false ) return;
            if( $nodeImg->hasAttribute('data-src') ) return;
            // if( $nodeImg->parentNode->tagName == 'noscript' ) return;


            $oldsrc = $nodeImg->getAttribute('src');
            $old_srcset = $nodeImg->getAttribute('srcset');
            $old_classes = $nodeImg->getAttribute('class');

            $nodeImg->setAttribute("data-src", $oldsrc );
            $nodeImg->setAttribute("data-srcset", $old_srcset);

            $nodeImg->removeAttribute("src");
            $nodeImg->removeAttribute("srcset");

            $nodeImg->setAttribute("class", trim($old_classes) . " {$class}");
        }

        public static function lazyIframe($nodeIframe, $class = 'lazyload')
        {
            $old_classes = $nodeIframe->getAttribute('class');
            $nodeIframe->setAttribute("class", trim($old_classes) . " {$class}");
        }
    }
}
