<?php

/**
 * Image Handler Interface
@package     Newtaxi
 * @subpackage  Contracts
 * @category    Image Handler
*/

namespace App\Contracts;

interface ImageHandlerInterface
{
	public function upload($image, $options);
	public function delete($image, $options);
	public function getImage($file_name, $options);
}