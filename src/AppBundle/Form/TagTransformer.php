<?php 

namespace AppBundle\Form;

use Symfony\Component\Form\DataTransformerInterface;

class TagTransformer implements DataTransformerInterface{

	public function transform($tags){

		$result = '';
		foreach ($tags as $tag) {
			$result .= $tag->getName().', ';
		}
		return $result;
	}

	public function reverseTransform($value)
	{
		dump( var: 'RT');
		dump($value);
		//TODO: IMPLEMENT reverseTRansform() method.
		return $value;
	}

}