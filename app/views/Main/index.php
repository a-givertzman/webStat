<!--banner-starts-->
<div class="bnr" id="home">
    <div  id="top" class="callbacks_container">
        <ul class="rslides" id="slider4">
            <li>
                <img src="images/bnr-1.jpg" alt=""/>
            </li>
            <li>
                <img src="images/bnr-2.jpg" alt=""/>
            </li>
            <li>
                <img src="images/bnr-3.jpg" alt=""/>
            </li>
        </ul>
    </div>
    <div class="clearfix"> </div>
</div>
<!--banner-ends-->

<!--about-starts-->
<?php if (!empty($brands)): ?>
    <div class="about">
        <div class="container">

            <div class="about-top grid-1">
                <?php foreach ($brands as $key => $brand): ?>

                    <div class="col-md-4 about-left">
                        <figure class="effect-bubba">
                            <img class="img-responsive" src="<?= './images/' .$brand['img'];?>" alt="<?= $brand['title'];?>"/>
                            <figcaption>
                                <h2><?= $brand['title'];?></h2>
                                <p><?= $brand['description'];?></p>
                            </figcaption>
                        </figure>
                    </div>

                <?php endforeach; ?>
                <div class="clearfix"></div>
            </div>

        </div>
    </div>
<?php endif; ?>
<!--about-end-->

<!--product-starts-->
<?php if (!empty($hits)): ?>
    <div class="product">
        <div class="container">
            <div class="product-top">

                <!--<div class="product-one">-->
                    <?php $currency = ishop\App::$app->getProperty('currency'); ?>
                    <?php foreach ($hits as $product): ?>
                        <div class="col-md-3 product-left">
                            <div class="product-main simpleCart_shelfItem">
                                <a href="product/<?= $product['alias'];?>" class="mask">
                                    <img class="img-responsive zoom-img" src="<?= './images/' .$product['img'];?>" width="125px" height="200px" alt="<?= $product['title'];?>"/>
                                </a>
                                <div class="product-bottom">
                                    <h3><a href="product/<?= $product['alias'];?>"><?= $product['title'];?></a></h3>
                                    <p>Explore Now</p>
                                    <h4>
                                        <a id="addToCartBtn" data-id="<?=$product['id'];?>" class="add-to-cart-link" href="cart/add?id=<?= $product['id'];?>"><i></i></a>
                                        <span class=" item_price"><?= $currency['symbol_left'];?> <?= $product['price'] * $currency['value'];?> <?= $currency['symbol_right'];?></span>
                                        <?php if (!empty($product['old_price'])): ?>
                                            <del><?= $currency['symbol_left'];?> <?=$product['old_price'] * $currency['value'];?> <?= $currency['symbol_right'];?></del>
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
                <!--</div>-->


            </div>
        </div>
    </div>
<?php endif; ?>
<!--product-starts-end-->