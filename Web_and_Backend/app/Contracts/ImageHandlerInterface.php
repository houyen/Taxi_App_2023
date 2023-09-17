<?php

/**
 * Image Handler Interface
 *
 * @package     Newtaxi
 * @subpackage  Contracts
 * @category    Image Handler
 * @author      Seen Technologies
 * @version     2.2.1
 * @link        https://seentechs.com
*/

namespace App\Contracts;

interface ImageHandlerInterface
{
	public function upload($image, $options);
	public function delete($image, $options);
	public function getImage($file_name, $options);
}