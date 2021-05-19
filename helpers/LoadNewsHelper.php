<?php

namespace app\helpers;

use Yii;
use app\models\News;

class LoadNewsHelper
{
    public static function loadNews()
    {
        //$xmlData = simplexml_load_file('https://lb.ua/rss/ukr/rss.xml');
		$xmlData = simplexml_load_file('https://www.sport.ru/rssfeeds/news.rss');
		
		foreach($xmlData->channel->item as $key => $item) {
			if (isset($item->title) && self::checkNews(strval($item->title)))
			{
				$model = new News();
				$model->title = strval($item->title);
				$model->content = strval($item->description);
				//$model->image = strval($item->enclosure['url']);
				$model->image = strval($item->children( 'media', True )->content->attributes()['url']);
				$model->save();
			}
		}
		return true;
    }
	
	private static function checkNews($title)
	{
		$id = News::find()
			->where(['title' => $title])
			->one();
        
		if (!isset($id->id))
			return true;
			
		return false;
	}
}