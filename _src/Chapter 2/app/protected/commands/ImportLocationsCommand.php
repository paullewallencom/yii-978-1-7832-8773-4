<?php

class ImportLocationsCommand extends CConsoleCommand
{
	// Run action
	public function actionImportLocations()
	{
		echo "Loading Data...\n";
		$data = $this->getData();

		echo "Truncating old data...\n";
		Location::model()->deleteAll();

		echo "Importing Data...\n";
		foreach($data as $id=>$content)
		{
			$model = new Location;
			$model->attributes = $content;
			$model->save();
		}
	}

	private function getData()
	{
		$file = __DIR__ . '/../data/parks.json';
		return CJSON::decode(file_get_contents($file));
	}
}