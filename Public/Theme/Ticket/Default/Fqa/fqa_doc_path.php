<ul>
    <?php foreach ($path as $key => $value): ?>
        <li>
            <label>
                <input type="checkbox" name="aid" value="<?= $value['article_mark'] ?>" doc_id="<?= $value['article_doc_id'] ?>">
                <?= $value['article_title'] ?>
            </label>
        </li>
        <?php if (!empty($value['child'])): ?>
            <?php $this->recursionDocPath($value['child']);  ?>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>