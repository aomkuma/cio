<?php
    
    namespace App\Service;
    
    use App\Model\News;

    use Illuminate\Database\Capsule\Manager as DB;
    
    class NewsService {

        public static function getNewsList($news_type = '', $actives = ''){
            return News::where(function($query) use ($news_type, $actives){
                        if(!empty($news_type)){
                            $query->where('news_type', $news_type);
                        }
                        if(!empty($actives)){
                            $query->where('actives', $actives);
                        }
                    })
                    ->orderBy('news_date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();      
        }

    	public static function getNews($id){
            return News::find($id); 
        }

        public static function updateNewsView($id){
            $model = News::find($id);
            $model->visit_count = (intval($model->visit_count) + 1);
            $model->save();
            return $model->id;
        }

        public static function updateNews($obj){

        	$model = News::find($obj['id']);
        	if(empty($model)){
        		$model = new News;
        		$model->create_date = date('Y-m-d H:i:s');
                
        	}
            $model->news_type = $obj['news_type'];
            $model->title_th = $obj['title_th'];
            $model->title_en = $obj['title_en'];
            $model->contents = $obj['contents'];
            $model->contents_en = $obj['contents_en'];
            $model->actives = $obj['actives'];
            $model->news_date = $obj['news_date'];
            $model->update_date = date('Y-m-d H:i:s');
            $model->save();
            return $model->id;
        }

        public static function updateNewsImagePath($id, $path){
            $model = News::find($id);
            $model->image_cover_path = $path;
            $model->save();
            return $model->id;
        }

        public static function removeNews($id){
            return News::find($id)->delete();
        }

    }