<?php

/**
 * Corpus2WikiAnnotator Document Information
 *
 * @file
 * @ingroup Extensions
 */
class TextInformationParser {

    /**
     * Parser function handler for {{#textinfo: foo:bar,foox:barx}}
     *
     * @param Parser $parser
     * @param string $arg
     *
     * @return string: HTML to insert in the page.
     */
   public static function parseTextInfo( $parser, $value) {

        $args = array_slice( func_get_args(), 1 );
        $info = $args[0];

        //////////////////////////////////////////
        // BUILD HTML                           //
        //////////////////////////////////////////

        $info = htmlspecialchars(Sanitizer::removeHTMLtags($info));
        $info = addslashes($info);

        $info = str_replace(",", "</td></tr><tr><td><b>", $info);
        $info = str_replace(":", "</b></td><td>", $info);

        $info = preg_replace("/(\d+)(_[^<]+)/", "[[Category:DDC$1|$1$2]]");
        $info = $parser->recursiveTagParse($info);

        $html  = '<table class="textinformation">';
        $html .= '<tr><th colspan=2>Text Information</th></tr>';
        $html .= '<tr><td><b>'.$info.'</td></tr></table>';

        return array(
            $html,
            'noparse' => true,
            'isHTML' => true,
            "markerType" => 'nowiki'
        );
    }

}
