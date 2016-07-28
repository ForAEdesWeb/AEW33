<?php $cat = $this->filters['nowStateCat']; ?>
<?php if (! empty($cat) and is_object($cat)): ?>
    <?php
    $catParams = json_decode($cat->params);

    // hidden function
    $hiddenCats = $this->filters['filter_hidden_categories'];
    $hiddenFunction = false;

    if (is_array($hiddenCats) and in_array($cat->id, $hiddenCats))
    {
        $hiddenFunction = true;
    }
    ?>
    <li>
        <a
            class="j2store-categories-href <?php echo $hiddenFunction ? " hiddenFunction " : ""; ?>"
            href="<?php echo JRoute::_("&filter_category={$cat->id}&category_title=" . urlencode($cat->title)); ?>"
            data-cat-id="<?php echo $cat->id; ?>">

            <?php if(isset($catParams->image) and ! empty($catParams->image)): ?>
                <img class="j2store-category-icon" src="<?php echo $catParams->image; ?>" />
            <?php endif; ?>

            <span class="j2store-category-title">
                <?php echo $cat->title; ?>
            </span>
        </a>

        <?php

        // 如果有女建立下個家庭
        if (! empty($cat->childCat))
        {
            // give next state
            $this->filters['nowStateCats'] = $cat->childCat;
            echo $this->loadTemplate('category_block');
        }

        ?>
    </li>
<?php endif; ?>