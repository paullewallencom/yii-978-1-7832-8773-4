<?php

class CMSSLugActiveRecord extends CMSActiveRecord
{
	public function validateSlug($attributes, $params)
	{
		return true;
	}
}