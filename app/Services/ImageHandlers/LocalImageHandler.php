<?php

namespace App\Services\ImageHandlers;

use File;
use Lang;

class LocalImageHandler
{
	/**
     * Upload image to storage
     *
     */
	public function upload($image, Array $image_data)
	{
		$return_data = array(
			'status' => false,
			'status_message' => Lang::get('admin_messages.errors.failed_to_upload_image'),
			'upload_driver' => '0'
		);
		if(!isset($image)) {
			return $return_data;
		}
		
		$tmp_name = $image->getPathName();
		$ext = strtolower($image->getClientOriginalExtension());
		$time = (isset($image_data['add_time']) && $image_data['add_time']) ? time() : '';
		$name = $image_data['name_prefix'].$time.'.'.$ext;
		if(isset($image_data['target_path'])) {
			$filename = $image_data['target_path'];
		}
		else {
			$filename = dirname($_SERVER['SCRIPT_FILENAME']).$image_data['target_dir'];
		}

		try {
			if (!file_exists($filename)) {
				mkdir($filename, 0777, true);
			}
			if($image->move($filename, $name)) {
				$return_data['status'] =  true;
				$return_data['status_message'] = Lang::get('admin_messages.common.image_uploaded_successfully');
			}
		}
		catch(\Exception $e) {
			return [
				'status' => false,
				'status_message' => $e->getMessage(),
			];
		}
		$return_data['src'] = rtrim(siteUrl(),'/').'/'.trim($image_data['target_dir'],'/').'/'.trim($name,'/');
		$return_data['file_name'] = $name;
		return $return_data;
	}

	/**
     * Delete image from storage
     *
     */
	public function destroy(Array $image_data)
	{
		if(!DELETE_STORAGE) {
			return [
				'status' => true,
				'status_message' => Lang::get('messages.common.failed'),
			];
		}
		$image_path = public_path($image_data['target_dir']."/".$image_data['name']);
		
		if(File::exists($image_path)) {
			try {
				File::delete($image_path);
				return [
					'status' => true,
					'status_message' => Lang::get('messages.common.success'),
				];
			}
			catch (\Exception $e) {
				return [
					'status' => false,
					'status_message' => $e->getMessage(),
				];
			}
		}
		return [
			'status' => false,
			'status_message' => Lang::get('messages.common.failed'),
		];
	}

	/**
     * Fetch the image based on driver
     *
     */
	public function fetch(Array $image_data)
	{
		$src = rtrim(siteUrl(),'/').'/'.trim($image_data['path'],'/').'/'.trim($image_data['name'],'/');

		if(isset($image_data['version_based']) && $image_data['version_based']) {
			$version = view()->shared('version');
			$src .='?v='.$version;
		}
		return $src;
	}
}