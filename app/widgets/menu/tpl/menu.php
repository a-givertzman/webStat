<?php $isParent = isset($category['chield']) ?>
<li>
    <a href="category/<?= $category['alias'] ;?>"><?= $category['title']; ?></a>
    <?php if($isParent): ?>
        <ul>
            <?= $this->getMenuHtml($category['chield']); ?>
        </ul>
    <?php endif; ?>
</li>