<?php

namespace AlterFalter\Service\Drive;
	
interface DriveService
{
	public function getMainFolderId();
	public function createFolder($name, $parentFolderId);
	public function folder($folderId);
	public function uploadFile($data, $filename, $extension, $folderId);
	public function getFile($fileId);
	public function deleteFile($fileId);
	public function createAccessToFile($fileId, $userId);
	public function userHasAccessToFile($fileId, $parentFolderId, $userId);
	public function createAccessToFolder($folderId, $userId);
	public function userHasAccessToFolder($folderId, $userId);
}
