<?php

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class WenpriseEmailHelper
{
    public function __construct()
    {
        define('WENPRISE_EMAIL_HELPER_PATH', dirname(__DIR__, 1));
    }

    /**
     * 发送HTML格式的邮件
     *
     * @param $email
     * @param $subject
     * @param $content
     * @param $headers
     *
     * @return void
     */
    function send_mail($email, $subject, $content, $headers = '')
    {
        $message = $this->render_template($content);

        if ( ! $headers) {
            $headers = 'Content-Type: text/html; charset="' . get_option('blog_charset') . "\"\n";
        }

        wp_mail($email, $subject, $message, $headers);
    }


    /**
     * 渲染 Html 邮件
     *
     * @param string $content 邮件正文, 建议table格式，以获得更好的兼容性
     * @param null   $css     string CSS 规则
     *
     * @return string
     */
    function render_template($content, $css = null)
    {
        $helper = new WenpriseTemplateHelper('wenprise',WENPRISE_EMAIL_HELPER_PATH . '/templates');

        ob_start();

        $helper->get_template('/email/template.php', compact('content'));

        $template = ob_get_clean();

        $cssToInlineStyles = new CssToInlineStyles();

        if ( ! $css) {
            $css = file_get_contents(WENPRISE_EMAIL_HELPER_PATH . '/templates/email/styles.css');
        }

        return $cssToInlineStyles->convert(
            $template,
            $css
        );
    }

}