<?php

namespace App\Service;

use App\Http\Requests\Admin\Post\UpdateRequest;
use App\Models\Post;
use Exception;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function store($data)
    {
        try {
            FacadesDB::beginTransaction();
            if (isset($data['tag_ids'])) {
                $tagIds = $data['tag_ids'];
                unset($data['tag_ids']);
            }

            $data['preview_image'] = Storage::disk('public')->put('/images', $data['preview_image']);
            $data['main_image'] = Storage::disk('public')->put('/images', $data['main_image']);
            $post = Post::FirstOrCreate($data);
            if (isset($tagIds)) {
                $post->tags()->sync($tagIds);
            }
            FacadesDB::commit();
        } catch (\Exception $exception) {
            FacadesDB::rollback();
            abort(500);
        }
    }

    public function update($data, $post)
    {
        try {
            FacadesDB::beginTransaction();
            if (isset($data['tag_ids'])) {
                $tagIds = $data['tag_ids'];
                unset($data['tag_ids']);
            }

            if (array_key_exists('preview_image', $data)) {
                $data['preview_image'] = Storage::disk('public')->put('/images', $data['preview_image']);
            }
            if (array_key_exists('main_image', $data)) {
                $data['main_image'] = Storage::disk('public')->put('/images', $data['main_image']);
            }
            $post->update($data);
            if (isset($tagIds)) {
                $post->tags()->sync($tagIds);
            }
            FacadesDB::commit();
        } catch (Exception $exception) {
            FacadesDB::rollback();
            abort(500);
        }

        return $post;
    }
}
