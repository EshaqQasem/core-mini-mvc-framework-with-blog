        <!-- Slideshow -->
        <div id="slideshow" class="carousel slide wow fadeInDown"  data-wow-duration="3s" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#slideshow" data-slide-to="0" class="active"></li>
            <li data-target="#slideshow" data-slide-to="1"></li>
            <li data-target="#slideshow" data-slide-to="2"></li>
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="<?php echo assets('blog/images/slides/1.jpg'); ?>" alt="...">
            </div>
            <div class="item">
                <img src="<?php echo assets('blog/images/slides/2.jpg'); ?>" alt="...">
            </div>
            <div class="item">
                <img src="<?php echo assets('blog/images/slides/3.jpg'); ?>" alt="...">
            </div>
          </div>

          <!-- Controls -->
          <a class="left carousel-control" href="#slideshow" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#slideshow" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
        <!--/ Slideshow -->
        <!-- Main Content -->
        <div class="col-sm-9 col-xs-12" id="main-content">
            <?php foreach ($posts AS $post) { ?>
                <!-- Post Box -->
                <div class="box post-box wow fadeIn" data-wow-duration="3s">
                    <div class="post-content">
                        <div class="social-icons pull-right">
                            <a href="#" class="facebook">
                                <span class="fa fa-facebook"></span>
                            </a>
                            <a href="#" class="twitter">
                                <span class="fa fa-twitter"></span>
                            </a>
                            <a href="#" class="google">
                                <span class="fa fa-google-plus"></span>
                            </a>
                        </div>
                        <h1 class="heading">
                            <a href="<?php echo url('/post/' . ($post->title) . '/' . $post->id); ?>">
                                <?php echo $post->title; ?></a>
                        </h1>
                        <div class="date-container">
                            <span class="fa fa-calendar"></span>
                            <span class="date"><?php echo date('d/m/Y h:i A',$post->created);?></span>
                        </div>
                        <div class="clearfix"></div>
                        <a href="<?php echo url('/post/' . ($post->title) . '/' . $post->id); ?>" class="image-box">
                            <img src="<?php echo assets('images/posts/' . $post->image); ?>" alt="<?php echo $post->title; ?>" />
                        </a>
                        <p class="details">
                            <?php //echo html_entity_decode(read_more($post->details, 20)) ;?>...
                        </p>
                        <a href="<?php echo url('/post/' . ($post->title) . '/' . $post->id); ?>" class="read-more">
                            Read More
                            <span class="fa fa-long-arrow-right"></span>
                        </a>
                    </div>

                    <div class="post-box-footer">
                        <a href="#" class="user">
                            By:
                            <span class="main"><?php  echo $post->userName;// $post->first_name . ' ' . $post->last_name; ?></span>
                        </a>
                        <a href="#" class="category">
                            In:
                            <span class="main"><?php echo $post->categoryName; ?></span>
                        </a>
                        <a href="#" class="comments">
                            <span class="main"><?php echo $post->commentCount; ?></span>
                            Comments
                        </a>
                    </div>
                </div>
                <!--/ Post Box -->

            <?php } ?>
        </div>
        <!--/ Main Content -->