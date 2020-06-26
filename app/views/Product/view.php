<!--start-breadcrumbs-->

<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="<?=PATH;?>">Home</a></li>

                <!--Хлебные крошки-->
                <?php if (!empty($breadcrumbs)): ?>
                    <?php foreach($breadcrumbs as $item): ?>
                        <li class="active">
                            <?php if (isset($item['alias'])): ?>
                                <a href="<?=PATH;?>/category/<?= $item['alias']; ?>"><?= $item['title']; ?></a>
                            <?php else: ?>
                                <?= $item['title']; ?>
                            <?php endif ?>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>

            </ol>
        </div>
    </div>
</div>

<!--end-breadcrumbs-->
<!--start-single-->
<?php $currency = ishop\App::$app->getProperty('currency'); ?>
<div class="single contact">
    <div class="container">
        <div class="single-main">
            <div class="col-md-9 single-main-left">
            <div class="sngl-top">
                <div class="col-md-5 single-top-left">
                    <!-- FlexSlider starts-->
                    <?php if(!empty($gallery)): ?>
                        <div class="flexslider">
                            <ul class="slides">
                                <?php foreach ($gallery as $key => $galleryItem): ?>
                                    <li data-thumb="images/<?= $galleryItem['img'] ;?>">
                                        <div class="thumb-image">
                                            <img src="images/<?= $galleryItem['img'] ;?>" data-imagezoom="true" class="img-responsive" alt=""/>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="thumb-image">
                            <img src="images/<?= $product['img'] ;?>" data-imagezoom="true" class="img-responsive" alt=""/>
                         </div>
                    <?php endif; ?>
                    <!-- FlexSlider end-->
                </div>
                <div class="col-md-7 single-top-right">
                    <div class="single-para simpleCart_shelfItem">
                        <h2><?= $product['title'] ;?></h2>
                        <!--<div class="star-on">
                            <ul class="star-footer">
                                <li><a href="#"><i> </i></a></li>
                                <li><a href="#"><i> </i></a></li>
                                <li><a href="#"><i> </i></a></li>
                                <li><a href="#"><i> </i></a></li>
                                <li><a href="#"><i> </i></a></li>
                            </ul>
                            <div class="review">
                                <a href="#"> 1 customer review </a>
                            </div>
                            <div class="clearfix"> </div>
                        </div>-->

                        <h5 class="item_price">
                            <?php
                                if (!empty($mods)) {
                                    $productPrice = $mods[0]['price'];
                                } else {
                                    $productPrice = $product['price'];
                                }
                                $productPrice = $productPrice * $currency['value'];
                            ?>
                            <?= $currency['symbol_left'];?> <?= $productPrice ;?> <?= $currency['symbol_right'];?>
                            <?php if (!empty($product['old_price'])): ?>
                                &nbsp<small><del>
                                    <?= $currency['symbol_left'];?> <?=$product['old_price'] * $currency['value'];?> <?= $currency['symbol_right'];?>
                                </del></small>
                            <?php endif; ?>
                        </h5>
                        <p><?= $product['content'] ;?></p>
                        <div class="available">
                        <ul>
                            <!--Модификации товара-->
                            <?php if (!empty($mods)): ?>
                                <!--Цвета товара-->
                                <li>Color<select id="colorSelector">
                                    <?php foreach($mods as $mod): ?>
                                        <option data-id=<?= $mod['id']; ?> data-title="<?= $mod['title']; ?>" data-price=<?= $mod['price']; ?> ><?= $mod['title']; ?></option>
                                    <?php endforeach; ?>
                                </select></li>
                            <?php endif; ?>
                            <div class="clearfix"> </div>
                        </ul>
                    </div>
                    <ul class="">
                        <li><span>Category:</span><span>
                            <?php $currentCategory = $category[$product['category_id']]; ?>
                            <?php $parentCategory = $category[ $currentCategory['parent_id'] ]; ?>
                            <?php $rootCategory = $category[ $parentCategory['parent_id'] ]; ?>
                            <a href="category/<?=$rootCategory['alias'];?>">
                                &nbsp;<?=$rootCategory['title'];?>,
                            </a>
                            <a href="category/<?=$parentCategory['alias'];?>">
                                &nbsp;<?=$parentCategory['title'];?>,
                            </a>
                            <a href="category/<?=$currentCategory['alias'];?>">
                                &nbsp;<?=$currentCategory['title'];?>,
                            </a>
                        </span></li>
                    </ul>

                    <input class="add-to-cart-qty" id="quantityInput" name="quantityInput" value=1 min=1 size="2" type="number">
                    <a id="addToCartBtn" data-id="<?=$product['id'];?>" class="add-cart add-to-cart-link" href="cart/add?id=<?=$product['id'];?>">BUY</a>

                </div>
            </div>
            <div class="clearfix"> </div>
            </div>
            <div class="tabs">
                    <ul class="menu_drop">
            <li class="item1"><a href="#"><img src="images/arrow.png" alt="">Description</a>
                    <ul>
                            <li class="subitem1"><a href="#">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</a></li>
                            <li class="subitem2"><a href="#"> Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore</a></li>
                            <li class="subitem3"><a href="#">Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes </a></li>
                    </ul>
            </li>
            <li class="item2"><a href="#"><img src="images/arrow.png" alt="">Additional information</a>
                    <ul>
                        <li class="subitem2"><a href="#"> Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore</a></li>
                            <li class="subitem3"><a href="#">Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes </a></li>
                    </ul>
            </li>
            <li class="item3"><a href="#"><img src="images/arrow.png" alt="">Reviews (10)</a>
                    <ul>
                            <li class="subitem1"><a href="#">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</a></li>
                            <li class="subitem2"><a href="#"> Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore</a></li>
                            <li class="subitem3"><a href="#">Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes </a></li>
                    </ul>
            </li>
            <li class="item4"><a href="#"><img src="images/arrow.png" alt="">Helpful Links</a>
                    <ul>
                        <li class="subitem2"><a href="#"> Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore</a></li>
                            <li class="subitem3"><a href="#">Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes </a></li>
                    </ul>
            </li>
            <li class="item5"><a href="#"><img src="images/arrow.png" alt="">Make A Gift</a>
                    <ul>
                            <li class="subitem1"><a href="#">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</a></li>
                            <li class="subitem2"><a href="#"> Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore</a></li>
                            <li class="subitem3"><a href="#">Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes </a></li>
                    </ul>
            </li>
    </ul>
            </div>

            <?php if (!empty($recentlyViewed)): ?>
                <div class="latestproducts">
                    <div class="product-one">
                        <h3>Просмотренные</h3>
                        <?php foreach ($recentlyViewed as $product): ?>

                            <div class="col-md-4 product-left p-left">
                                <div class="product-main simpleCart_shelfItem">
                                    <a href="product/<?= $product['alias'];?>" class="mask"><img class="img-responsive zoom-img" src="<?= './images/' .$product['img'];?>" alt="<?= $product['title'];?>"/></a>
                                    <div class="product-bottom">
                                        <h3><a href="product/<?= $product['alias'];?>"><?= $product['title'];?></a></h3>
                                        <p>Explore Now</p>
                                        <h4>
                                            <a class="add-to-cart-link" href="cart/add?id=<?= $product['id'];?>"><i></i></a>
                                            <span class=" item_price">
                                                <?= $currency['symbol_left'];?> <?= $product['price'] * $currency['value'];?> <?= $currency['symbol_right'];?>
                                            </span>
                                            <?php if (!empty($product['old_price'])): ?>
                                                <del>
                                                    <?= $currency['symbol_left'];?> <?=$product['old_price'] * $currency['value'];?> <?= $currency['symbol_right'];?>
                                                </del>
                                            <?php endif; ?>
                                        </h4>
                                    </div>
                                    <?php if (!empty($product['old_price'])): ?>
                                        <div class="srch">
                                            <span> - <?= round(100*(1 - $product['price']/$product['old_price']), 1) ;?> %</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <?php endforeach; ?>
                        <div class="clearfix"></div>
                    </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($related)): ?>
                <div class="latestproducts">
                    <div class="product-one">
                        <h3>С этим товаром часто покупают</h3>
                        <?php foreach ($related as $product): ?>

                            <div class="col-md-4 product-left p-left">
                                <div class="product-main simpleCart_shelfItem">
                                    <a href="product/<?= $product['alias'];?>" class="mask"><img class="img-responsive zoom-img" src="<?= './images/' .$product['img'];?>" alt="<?= $product['title'];?>"/></a>
                                    <div class="product-bottom">
                                        <h3><a href="product/<?= $product['alias'];?>"><?= $product['title'];?></a></h3>
                                        <p>Explore Now</p>
                                        <h4>
                                            <a class="add-to-cart-link" href="cart/add?id=<?= $product['id'];?>"><i></i></a>
                                            <span class=" item_price">
                                                <?= $currency['symbol_left'];?> <?= $product['price'] * $currency['value'];?> <?= $currency['symbol_right'];?>
                                            </span>
                                            <?php if (!empty($product['old_price'])): ?>
                                                <del>
                                                    <?= $currency['symbol_left'];?> <?=$product['old_price'] * $currency['value'];?> <?= $currency['symbol_right'];?>
                                                </del>
                                            <?php endif; ?>
                                        </h4>
                                    </div>
                                    <?php if (!empty($product['old_price'])): ?>
                                        <div class="srch">
                                            <span> - <?= round(100*(1 - $product['price']/$product['old_price']), 1) ;?> %</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                        <?php endforeach; ?>
                        <div class="clearfix"></div>
                    </div>
            </div>
            <?php endif; ?>

    </div>
            <div class="col-md-3 single-right">
                    <div class="w_sidebar">
                            <section  class="sky-form">
                                    <h4>Catogories</h4>
                                    <div class="row1 scroll-pane">
                                            <div class="col col-4">
                                                    <label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>All Accessories</label>
                                            </div>
                                            <div class="col col-4">
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Women Watches</label>
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Kids Watches</label>
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Men Watches</label>
                                            </div>
                                    </div>
                            </section>
                            <section  class="sky-form">
                                    <h4>Brand</h4>
                                    <div class="row1 row2 scroll-pane">
                                            <div class="col col-4">
                                                    <label class="checkbox"><input type="checkbox" name="checkbox" checked=""><i></i>kurtas</label>
                                            </div>
                                            <div class="col col-4">
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Sonata</label>
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Titan</label>
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Casio</label>
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Omax</label>
                                                    <label class="checkbox"><input type="checkbox" name="checkbox" ><i></i>shree</label>
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Fastrack</label>
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Sports</label>
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Fossil</label>
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Maxima</label>
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Yepme</label>
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Citizen</label>
                                                    <label class="checkbox"><input type="checkbox" name="checkbox"><i></i>Diesel</label>
                                            </div>
                                    </div>
                            </section>
                            <section class="sky-form">
                                    <h4>Colour</h4>
                                            <ul class="w_nav2">
                                                    <li><a class="color1" href="#"></a></li>
                                                    <li><a class="color2" href="#"></a></li>
                                                    <li><a class="color3" href="#"></a></li>
                                                    <li><a class="color4" href="#"></a></li>
                                                    <li><a class="color5" href="#"></a></li>
                                                    <li><a class="color6" href="#"></a></li>
                                                    <li><a class="color7" href="#"></a></li>
                                                    <li><a class="color8" href="#"></a></li>
                                                    <li><a class="color9" href="#"></a></li>
                                                    <li><a class="color10" href="#"></a></li>
                                                    <li><a class="color12" href="#"></a></li>
                                                    <li><a class="color13" href="#"></a></li>
                                                    <li><a class="color14" href="#"></a></li>
                                                    <li><a class="color15" href="#"></a></li>
                                                    <li><a class="color5" href="#"></a></li>
                                                    <li><a class="color6" href="#"></a></li>
                                                    <li><a class="color7" href="#"></a></li>
                                                    <li><a class="color8" href="#"></a></li>
                                                    <li><a class="color9" href="#"></a></li>
                                                    <li><a class="color10" href="#"></a></li>
                                            </ul>
                            </section>
                            <section class="sky-form">
                                    <h4>discount</h4>
                                    <div class="row1 row2 scroll-pane">
                                            <div class="col col-4">
                                                    <label class="radio"><input type="radio" name="radio" checked=""><i></i>60 % and above</label>
                                                    <label class="radio"><input type="radio" name="radio"><i></i>50 % and above</label>
                                                    <label class="radio"><input type="radio" name="radio"><i></i>40 % and above</label>
                                            </div>
                                            <div class="col col-4">
                                                    <label class="radio"><input type="radio" name="radio"><i></i>30 % and above</label>
                                                    <label class="radio"><input type="radio" name="radio"><i></i>20 % and above</label>
                                                    <label class="radio"><input type="radio" name="radio"><i></i>10 % and above</label>
                                            </div>
                                    </div>
                            </section>
                    </div>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
</div>
<!--end-single-->