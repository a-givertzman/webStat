<li>
    <a href="?id=<?= $id ;?>"><?= $category['title']; ?></a>
    <?php if(!empty($category['chield'])): ?>
        <ul>
            <?= $this->getMenuHtml($category['chield']); ?>
        </ul>
    <?php endif; ?>
</li>