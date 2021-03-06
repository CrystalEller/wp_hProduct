<div class="product_plugin" itemscope itemtype="http://schema.org/Product">
    <table class="tg">
        <tr>
            <td colspan="4" itemprop="name"><?php echo !empty($product_data['name']) ? $product_data['name'] : ''; ?></td>
        </tr>
        <tr>
            <?php if(!empty($product_data['image'])):?>
                <td><img src="<?php echo $product_data['image']; ?>" itemprop="image"></td>
                <td class="description" colspan="3" itemprop="description">
                    <?php echo !empty($product_data['description']) ? $product_data['description'] : ''; ?>
                </td>
                <?php else:?>
                <td class="description" colspan="4" itemprop="description">
                    <?php echo !empty($product_data['description']) ? $product_data['description'] : ''; ?>
                </td>
            <?php endif;?>
        </tr>
        <tr itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <td colspan="2">Цена</td>
            <td colspan="2">
                <span itemprop="price"><?php echo !empty($product_data['price']) ? $product_data['price'] : ''; ?></span>
                <span itemprop="priceCurrency"><?php echo !empty($product_data['currency']) ? $product_data['currency'] : ''; ?></span>
            </td>
        </tr>
    </table>
</div>
