<?php

$this->filters['nowStateCat'] = null;

$roots = array();

foreach ($this->filters['filter_categories'] as $root)
{
    if ($root->isRoot)
    {
        $roots[] = $root;
    }
}

$this->filters['nowStateCats'] = $roots;

echo $this->loadTemplate('category_block');
