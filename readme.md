## 主要功能
用来在WordPress中发送html格式的电子邮件。

## 使用方法

```
ob_start();

// echo 字符串形式的表格内容。

$content = ob_get_clean();

$helper = new WenpriseEmailHelper();
$helper->send_mail('iwillhappy1314@gmail.com', 'This is a test', $content);
```