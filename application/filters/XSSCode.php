<?php
/**
 * XSS攻撃になりそうなコードを削除するフィルタークラス
 *
 * @since   2013.05.08
 * @auther  k.imai
 */
require_once 'Zend/Filter/Interface.php';

class Filter_XSSCode implements Zend_Filter_Interface
{
    /**
     * フィルターを実行するメソッド
     * フィルタリングする際はこのメソッドを呼び出す
     *
     * @param  Mixed フィルタリング対象文字列
     * @return Mixed フィルタリング処理後の文字列
     */
    public function filter($value)
    {
        return $this->_clean($value);
    }

    /**
     * 実際にフィルタリングをする処理
     *
     * @param  Mixed フィルタリング対象文字列
     * @return Mixed フィルタリング処理後の文字列
     */
    protected function _clean($value)
    {
        $search = array(
            '@<script[^>]*?>.*?</script>@si',          //javascriptコードを削除
            '@<[\/\!]*?[^<>]*?>@si',                   //HTMLコードを削除
            '@<style[^>]*?>.*?</style>@siU',           //styleタグを削除
            '@<![\s\S]*?--[ \t\n\r]*>@',               //CDATAタグを削除
        );

        return is_array($value) ? array_map(array($this, '_clean'), $value) : preg_replace($search, '', $value);
    }

}