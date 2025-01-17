<?php namespace App\Libraries\CafeVariome\Query;

/**
 * AbstractQuery.php
 * Created 13/07/2021
 *
 * @author Mehdi Mehtarizadeh
 *
 */

use App\Libraries\CafeVariome\CafeVariome;
use App\Libraries\CafeVariome\Core\DataPipeLine\Index\Neo4J;
use App\Libraries\CafeVariome\Entities\Source;
use App\Libraries\CafeVariome\Helpers\Core\ElasticsearchHelper;
use App\Models\Attribute;
use App\Models\AttributeMapping;
use App\Models\Value;
use App\Models\ValueMapping;
use Elasticsearch\ClientBuilder;

abstract class AbstractQuery
{

	public abstract function Execute(array $clause, Source $source);

	protected function getNeo4JInstance(): Neo4J
	{
		return new Neo4J();
	}

	protected function getESInstance(): \Elasticsearch\Client
	{
		$setting = CafeVariome::Settings();

		$hosts = array($setting->GetElasticSearchUri());
		return ClientBuilder::create()->setHosts($hosts)->build();
	}

	protected function GetESIndexPrefix(): string
	{
		return ElasticsearchHelper::GetIndexPrefix();
	}

	protected function GetESIndexName(int $source_id): string
	{
		return ElasticsearchHelper::GetSourceIndexName($source_id);
	}

	protected function getAttribute(string $attribute, int $source_id)
	{
		// If attribute exists, return it.
		$attributeModel = new Attribute();
		$attributeObj = $attributeModel->getAttributeByNameAndSourceId($attribute, $source_id);
		if ($attributeObj != null) {
			return $attributeObj;
		}

		// If attribute mapping exists, return the corresponding attribute.
		$attributeMappingModel = new AttributeMapping();
		return $attributeMappingModel->getAttributeByMappingNameAndSourceId($attribute, $source_id);
	}

	protected function getValue(string $value, int $attribute_id)
	{
		//If value exists, return it.
		$valueModel = new Value();
		$valueObj = $valueModel->getValueByNameAndAttributeId($value, $attribute_id);
		if ($valueObj != null){
			return $valueObj;
		}

		// If value mapping exists, return the corresponding value.
		$valueMappingModel = new ValueMapping();
		return $valueMappingModel->getValueByMappingNameAndAttributeId($value, $attribute_id);
	}
}
