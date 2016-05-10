<?php
class bbcode {
    var $tags;
    var $smileys;

    function bbcode()
    {
        $this->tags = array();
        $this->smileys = array();

        $this->register_bbcode("b", FALSE, FALSE, FALSE, "<span class=\"b\">\\1</span>", NULL);
        $this->register_bbcode("i", FALSE, FALSE, FALSE, "<span class=\"i\">\\1</span>", NULL);
        $this->register_bbcode("u", FALSE, FALSE, FALSE, "<span class=\"u\">\\1</span>", NULL);
        $this->register_bbcode("link", FALSE, TRUE, FALSE, "<a href=\"\\1\">\\1</a>", "<a href=\"\\1\">\\2</a>");
        $this->register_bbcode("url", FALSE, TRUE, FALSE, "<a href=\"\\1\">\\1</a>", "<a href=\"\\1\">\\2</a>");
        $this->register_bbcode("img", FALSE, TRUE, FALSE, "<img src=\"\\1\" alt=\"\" />", "<img src=\"\\1\" alt=\"\\2\" />");
    }

    function register_bbcode($tagname, $noclose, $can_have_param, $must_have_param, $replacement, $param_replacement)
    {
        $this->tags[$tagname] = array(
            "tagname"           => $tagname,
            "noclose"           => $noclose,
            "can_have_param"    => $can_have_param,
            "must_have_param"   => $must_have_param,
            "replacement"       => $replacement,
            "param_replacement" => $param_replacement
        );
    }

    function register_smiley($smiley, $pic)
    {
        $this->smileys[$smiley] = $pic;
    }

    function decode($text, $parse_bbcode = TRUE, $parse_smileys = TRUE)
    {
        $text = strip_tags($text);

        if ($parse_bbcode) {
            $continue = TRUE;
            while ($continue) {
                foreach ($this->tags as $tagname => $definition) {
                    $continue = FALSE;
                    $num = 0;

                    $pattern_parm = "\\[{$definition["tagname"]}=([^]]+)\\]([^[]+)\\[\\/{$definition["tagname"]}\\]";
                    $pattern_noparm = "\\[{$definition["tagname"]}\\]([^[]+)\\[\\/{$definition["tagname"]}\\]";
                    $text = preg_replace("/{$pattern_noparm}/i", $definition["replacement"], $text, -1, $num);
                    $text = preg_replace("/{$pattern_parm}/i", $definition["param_replacement"], $text, -1, $num);

                    if ($num > 0) {
                        $continue = TRUE;
                    }
                }
            }

            $text = str_replace(array("\r", "\n", "\r\n"), "<br />\n", $text);
        }

        if ($parse_smileys) {
            foreach ($this->smileys as $smiley => $pic) {
                $text = str_replace($smiley, "<img src=\"{$pic}\" alt=\"{$smiley}\">", $text);
            }
        }

        return $text;
    }
}
