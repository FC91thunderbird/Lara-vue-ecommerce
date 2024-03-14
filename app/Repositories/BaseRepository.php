<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BaseRepository {
    protected $model;

    public function getAll($relations = []){
        try {
            return $this->model->with($relations)->get();
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }

    public function getById($id, $relations = []){
        try {
            return $this->model->with($relations)->find($id);
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }

    

    public function store($data){
        try {
            if(isset($data['image']) && $data['image']->isValid()){
                $data['image'] = $this->uploadImage($data['image']);
            }

            return $this->model->create($data);
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }

    public function update($id, $data){
        try {
            $model = $this->model->find($id);

            if(!$model){
                return false;
            }
            // if(isset($data['image']) && $data['image']->isValid()){
            //     $data['image'] = $this->uploadImage($data['image']);
            // }

            if(isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile && $data['image']->isValid()){
                $data['image'] = $this->uploadImage($data['image']);
            }

            $model->update($data);
            return $model;
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }


    public function delete($id){
        try {
            $model = $this->model->find($id);

            if($model){
                $model->delete();
            }
            return $model;
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }   

    public function uploadImage($image){
        // Get the class name of the model
        $modelName = class_basename($this->model);
        
        // Generate a unique name for the image
        $imageName = uniqid() . '_' . $image->getClientOriginalName();

        // Store the image in the model-specific folder within the 'public' disk
        $image->storeAs("public/{$modelName}", $imageName);

        // Return the path to the stored image
        return "storage/{$modelName}/{$imageName}";
    }
}