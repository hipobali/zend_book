<?php

class Application_Model_Book extends Application_Model_Abstract 
{
	public static function getBookData()
	{
		$db = self::getDb();
		$sql = "SELECT
					b.id Id,
					b.bookname BookName,
					b.author Author,
					b.type Type 
				FROM book B";
		$result = $db->fetchAll($sql);
		return $result;
	}
    
	public static function saveBookData($Data)
	{
		$db=self::getDb();
		try
     	{
     		$db->beginTransaction();
     		$db->insert('book', $Data);
			$lastInsertId = $db->lastInsertId('id');
			$db->commit();
			return $lastInsertId;
		} 	
		catch (Exception $e) 
		{
			$db->rollBack();
			throw new RuntimeException($e->getMessage());
		}
	}

	public static function deleteData($id)
    {
     	$db = self::getDb();
        try 
        {
            $db->beginTransaction();
            $db->delete('book', 'id=' . $id);
            $db->commit();
        } 
        catch (Exception $e) 
        {
            $db->rollBack();
            return 'fail';
        }
    }
}
