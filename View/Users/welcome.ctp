<?php $this->set('pageClass', 'welcome'); ?>
<div class="frontpage">
    <div class="left-col">
        <h2>We love stuff</h2>
        <p>Get the most out of the products you own and the services you use everyday, or discover new products that suit you.</p>
        <div id="search" class="<?php echo isset($class) ? $class : ''; ?>">
            <div id="suggest-wrapper">
                <input id="suggest"
                       type="text"
                       name="product_suggest"
                       class="idle"
                       value="Search for a product or brand"
                       autocomplete="off"/>
                <div id="suggest-landing"></div>
            </div>
        </div>
    </div>
    <div class="right-col">
        <?php
        echo $this->Form->create('User', array(
            'controller' => 'users',
            'action' => 'signup',
            'id' => 'signup',
            'inputDefaults' => array(
                'label' => false,
                'autocomplete' => 'off',
                'div' => false
            )
        ));
        ?>
        <h3>Not part of Consumer Love? <em>Join Today!</em></h3>
        <?php echo $this->Form->input('username', array('placeholder' => 'Username', 'class' => 'signup-username', 'id' => 'welcome-username')); ?>
        <?php echo $this->Form->input('password', array('placeholder' => 'Password', 'class' => 'signup-password', 'id' => 'welcome-password')); ?>
        <?php echo $this->Form->input('email', array('placeholder' => 'Email', 'class' => 'signup-email')); ?>
        <?php echo $this->Form->submit('Sign up', array('class' => 'btn signup-submit')); ?>
        <?php echo $this->Form->end(); ?>
    </div>
    <h3 class="featuring">Featuring these products and more</h3>
    <div id="showcase-wrapper">
        <ul class="showcase">
            <?php foreach ($products as $product): ?>
                <li><?php echo $this->Link->product($product, $this->Love->productImage($product, 64), array('title' => $product['Product']['name'], 'escape' => false)); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>