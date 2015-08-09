<table>
    <tr>
        <td><?php echo __('Имя', 'product-plugin'); ?>:</td>
        <td><input type="text" name="product[name]" value="<?php echo esc_attr($product_name); ?>"></td>
    </tr>
    <tr>
        <td><?php echo __('Описание', 'product-plugin'); ?>:</td>
        <td><input type="text" name="product[description]" value="<?php echo esc_attr($product_description); ?>"></td>
    </tr>
    <tr>
        <td><?php echo __('Цена', 'product-plugin'); ?>:</td>
        <td><input type="text" name="product[price]" value="<?php echo esc_attr($product_price); ?>"></td>
    </tr>
    <tr>
        <td><?php echo __('Валюта', 'product-plugin'); ?></td>
        <td>
            <select name="product[currency]">
                <option value="EUR"<?php echo selected($product_currency, 'EUR', false); ?>>EUR</option>
                <option value="RUB"<?php echo selected($product_currency, 'RUB', false); ?>>RUB</option>
                <option value="UAH"<?php echo selected($product_currency, 'UAH', false); ?>>UAH</option>
                <option value="USD"<?php echo selected($product_currency, 'USD', false); ?>>USD</option>
            </select>
        </td>
    </tr>
</table>

<div class="image">
    <input type="hidden" name="product[image]"
           id="product_image_url" class="regular-text" value="<?php echo !empty($product_img) ? $product_img : ''; ?>">
    <?php if (!empty($product_img)): ?>
        <div id="product_img_wrapper">
            <img id="product_image" src="<?php echo $product_img; ?>" alt=""/>
        </div>
    <?php endif; ?>
    <input type="hidden" name="delete-btn" id="delete-btn" class="button-secondary" value="Удалить изображение">
    <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Загрузить изображение">
</div>

<table>
    <tr>
        <td colspan="2">
            <hr>
        </td>
    </tr>
    <tr>
        <td colspan="2"><strong><?php echo __('Шорткоды', 'product-plugin'); ?></strong></td>
    </tr>
    <tr>
        <td><?php echo __('Показать продукт определенного поста\страницы', 'product-plugin'); ?>:</td>
        <td>[product post=post_id]</td>
    </tr>
    <tr>
        <td><?php echo __('Показать продукт текущего поста\страницы', 'product-plugin'); ?>:</td>
        <td>[product]</td>
    </tr>
</table>