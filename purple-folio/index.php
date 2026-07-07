<?php get_header(); ?>

<main>

<!-- ============ HOME ============ -->
<section class="page active" id="page-home">
  <div class="container">
    <div class="hero">
      <div class="hero-copy">
        <div class="hero-eyebrow" data-anim="fade-up">
          <span class="typing gradient-text" id="typing" data-phrases="Yousuf Zai | WordPress Developer | Elementor Expert">Yousuf Zai</span>
          <span class="chip glass"><i class="dot"></i>Available</span>
        </div>
        <h1 class="display" data-anim="fade-up" data-anim-delay="80">
          Crafting <span class="gradient-text">WordPress</span> experiences that feel unreal.
        </h1>
        <p class="lead" data-anim="fade-up" data-anim-delay="160">
          I'm Yousuf Zai — an independent developer building custom themes, headless WordPress stacks and blazing-fast websites for founders and studios worldwide.
        </p>
        <div class="hero-cta" data-anim="fade-up" data-anim-delay="240">
          <a href="#work" data-nav="work" class="btn btn-primary">View Work <span class="arrow">→</span></a>
          <a href="#contact" data-nav="contact" class="btn btn-ghost">Start a Project</a>
        </div>
        <div class="stats" data-anim="fade-up" data-anim-delay="320">
          <div class="stat"><div class="stat-num gradient-text" data-count="80" data-suffix="+">0</div><div class="stat-label">Sites shipped</div></div>
          <div class="stat"><div class="stat-num gradient-text" data-count="9" data-suffix="y">0</div><div class="stat-label">In WordPress</div></div>
          <div class="stat"><div class="stat-num gradient-text" data-count="100" data-suffix="">0</div><div class="stat-label">Lighthouse avg</div></div>
        </div>
      </div>
      <div class="hero-art" data-anim="blur-in">
        <div class="glow-orb"></div>
        <img src="<?php echo customtheme_asset( 'hero-wordpress.jpg' ); ?>" alt="WordPress development illustration" class="float" />
      </div>
    </div>

    <!-- SERVICES -->
    <section class="section">
      <div class="section-head" data-anim="fade-up">
        <div class="eyebrow">What I do</div>
        <h2>Services built for <span class="gradient-text">modern WordPress</span>.</h2>
      </div>
      <div class="grid grid-3">
        <article class="card glass" data-anim="fade-up">
          <div class="icon-badge">◇</div>
          <h3>Custom Themes</h3>
          <p>Bespoke, block-based themes engineered around your brand — no bloat, no page builders required.</p>
        </article>
        <article class="card glass" data-anim="fade-up" data-anim-delay="120">
          <div class="icon-badge">⚡</div>
          <h3>Headless WordPress</h3>
          <p>Decoupled architectures with Next.js or Astro powered by the WP REST & GraphQL APIs.</p>
        </article>
        <article class="card glass" data-anim="fade-up" data-anim-delay="240">
          <div class="icon-badge">◉</div>
          <h3>WooCommerce</h3>
          <p>Fast, conversion-focused stores with custom checkout flows and subscription logic.</p>
        </article>
      </div>
    </section>

    <!-- FEATURED -->
    <section class="section">
      <div class="section-head-row">
        <div data-anim="fade-up">
          <div class="eyebrow">Selected work</div>
          <h2>Recent projects</h2>
        </div>
        <a href="#work" data-nav="work" class="see-all">See all →</a>
      </div>
      <div class="grid grid-3">
        <a href="#work" data-nav="work" class="project glass" data-anim="fade-up">
          <img src="<?php echo customtheme_asset( 'project-1.jpg' ); ?>" alt="Halcyon Studio" />
          <div class="project-meta"><span class="eyebrow">Custom Theme</span><span class="project-title">Halcyon Studio</span></div>
        </a>
        <a href="#work" data-nav="work" class="project glass" data-anim="fade-up" data-anim-delay="120">
          <img src="<?php echo customtheme_asset( 'project-2.jpg' ); ?>" alt="Ribbon FM" />
          <div class="project-meta"><span class="eyebrow">Headless WP</span><span class="project-title">Ribbon FM</span></div>
        </a>
        <a href="#work" data-nav="work" class="project glass" data-anim="fade-up" data-anim-delay="240">
          <img src="<?php echo customtheme_asset( 'project-3.jpg' ); ?>" alt="Orbit Commerce" />
          <div class="project-meta"><span class="eyebrow">WooCommerce</span><span class="project-title">Orbit Commerce</span></div>
        </a>
      </div>
    </section>

    <!-- CTA -->
    <section class="cta glass" data-anim="fade-up">
      <div class="cta-glow"></div>
      <div class="cta-inner">
        <h2>Ready to build something <span class="gradient-text">extraordinary?</span></h2>
        <p>Let's turn your idea into a fast, beautiful WordPress site your users will love.</p>
        <a href="#contact" data-nav="contact" class="btn btn-primary">Get in touch →</a>
      </div>
    </section>
  </div>
</section>

<!-- ============ WORK ============ -->
<section class="page" id="page-work">
  <div class="container">
    <section class="hero hero-sub">
      <div>
        <div class="eyebrow" data-anim="fade-up">Case studies</div>
        <h1 class="display" data-anim="fade-up" data-anim-delay="80"><span class="gradient-text">Work</span> that ships.</h1>
        <p class="lead" data-anim="fade-up" data-anim-delay="160">A selection of WordPress builds across editorial, commerce and product-marketing surfaces.</p>
      </div>
      <img src="<?php echo customtheme_asset( 'work-3d.jpg' ); ?>" alt="3D purple cube" class="float hero-sub-img" data-anim="scale-in" />
    </section>

    <div class="grid grid-2">
      <article class="card glass work-card" data-anim="fade-up">
        <div class="thumb"><img src="<?php echo customtheme_asset( 'project-1.jpg' ); ?>" alt="Halcyon Studio" /></div>
        <div class="card-body">
          <div class="meta"><span>Custom Theme</span><span>2025</span></div>
          <h3>Halcyon Studio</h3>
          <p>A blocks-first portfolio for an award-winning design studio, built on a headless-ready custom theme.</p>
        </div>
      </article>
      <article class="card glass work-card" data-anim="fade-up" data-anim-delay="120">
        <div class="thumb"><img src="<?php echo customtheme_asset( 'project-2.jpg' ); ?>" alt="Ribbon FM" /></div>
        <div class="card-body">
          <div class="meta"><span>Headless WP</span><span>2025</span></div>
          <h3>Ribbon FM</h3>
          <p>A music publication running on WordPress + Next.js with editorial scheduling and audio embeds.</p>
        </div>
      </article>
      <article class="card glass work-card" data-anim="fade-up">
        <div class="thumb"><img src="<?php echo customtheme_asset( 'project-3.jpg' ); ?>" alt="Orbit Commerce" /></div>
        <div class="card-body">
          <div class="meta"><span>WooCommerce</span><span>2024</span></div>
          <h3>Orbit Commerce</h3>
          <p>Subscription-based DTC brand with custom checkout, loyalty tier logic and Stripe billing.</p>
        </div>
      </article>
      <article class="card glass work-card" data-anim="fade-up" data-anim-delay="120">
        <div class="thumb"><img src="<?php echo customtheme_asset( 'project-1.jpg' ); ?>" alt="Fossa Health" /></div>
        <div class="card-body">
          <div class="meta"><span>Custom Theme</span><span>2024</span></div>
          <h3>Fossa Health</h3>
          <p>HIPAA-conscious marketing site with encrypted intake forms and multi-language routing.</p>
        </div>
      </article>
      <article class="card glass work-card" data-anim="fade-up">
        <div class="thumb"><img src="<?php echo customtheme_asset( 'project-2.jpg' ); ?>" alt="Meridian Type" /></div>
        <div class="card-body">
          <div class="meta"><span>Headless WP</span><span>2023</span></div>
          <h3>Meridian Type</h3>
          <p>Type foundry storefront with live font previews and license-based downloads.</p>
        </div>
      </article>
      <article class="card glass work-card" data-anim="fade-up" data-anim-delay="120">
        <div class="thumb"><img src="<?php echo customtheme_asset( 'project-3.jpg' ); ?>" alt="Nocturne Club" /></div>
        <div class="card-body">
          <div class="meta"><span>WooCommerce</span><span>2023</span></div>
          <h3>Nocturne Club</h3>
          <p>Membership platform with gated content, private RSS feeds and Discord role sync.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============ ABOUT ============ -->
<section class="page" id="page-about">
  <div class="container">
    <section class="hero">
      <div class="hero-art" data-anim="blur-in">
        <div class="glow-orb"></div>
        <img src="<?php echo customtheme_asset( 'profile-yousuf-zai.png' ); ?>" alt="Yousuf Zai" class="profile-img float" />
      </div>
      <div>
        <div class="eyebrow" data-anim="fade-up">About</div>
        <h1 class="display" data-anim="fade-up" data-anim-delay="80">Hi, I'm <span class="gradient-text">Yousuf Zai</span>.</h1>
        <p class="lead" data-anim="fade-up" data-anim-delay="160">I've spent the last nine years building WordPress sites for founders, studios and magazines — from tiny brochure sites to headless commerce stacks handling millions of pageviews. I care deeply about performance, developer experience and shipping work that feels a little bit magical.</p>
        <p class="lead" data-anim="fade-up" data-anim-delay="240">Based in Lisbon. Working with teams worldwide. Slightly obsessed with typography, purple gradients and clean commit histories.</p>
      </div>
    </section>

    <section class="section">
      <div class="eyebrow" data-anim="fade-up">The stack</div>
      <h2 data-anim="fade-up">Tools of the trade.</h2>
      <div class="chips" id="stackChips"></div>
    </section>

    <section class="section">
      <div class="eyebrow" data-anim="fade-up">Timeline</div>
      <h2 data-anim="fade-up">A short story.</h2>
      <div class="timeline" id="timeline"></div>
    </section>
  </div>
</section>

<!-- ============ CONTACT ============ -->
<section class="page" id="page-blog">
  <div class="container">
    <section class="hero hero-sub">
      <div>
        <div class="eyebrow" data-anim="fade-up">Blog</div>
        <h1 class="display" data-anim="fade-up" data-anim-delay="80">Ideas for <span class="gradient-text">better WordPress</span> builds.</h1>
        <p class="lead" data-anim="fade-up" data-anim-delay="160">Notes on custom themes, Elementor workflows, performance and maintainable WordPress systems.</p>
      </div>
      <img src="<?php echo customtheme_asset( 'work-3d.jpg' ); ?>" alt="Purple WordPress blog visual" class="float hero-sub-img" data-anim="scale-in" />
    </section>

    <section class="section">
      <div class="section-head-row">
        <div data-anim="fade-up">
          <div class="eyebrow">Latest posts</div>
          <h2>From the blog</h2>
        </div>
      </div>
      <div class="blog-grid">
        <?php
        $blog_query = new WP_Query( array(
          'post_type'           => 'post',
          'post_status'         => 'publish',
          'posts_per_page'      => 6,
          'ignore_sticky_posts' => true,
        ) );
        if ( $blog_query->have_posts() ) :
          while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
            <article <?php post_class( 'blog-card glass' ); ?> data-anim="fade-up">
              <a href="<?php the_permalink(); ?>">
                <div class="eyebrow sm"><?php echo esc_html( get_the_date() ); ?></div>
                <h2><?php the_title(); ?></h2>
                <p><?php echo esc_html( wp_trim_words( get_the_excerpt() ?: wp_strip_all_tags( get_the_content() ), 22 ) ); ?></p>
                <span class="see-all">Read article →</span>
              </a>
            </article>
          <?php endwhile;
          wp_reset_postdata();
        else : ?>
          <article class="blog-card glass" data-anim="fade-up">
            <div class="eyebrow sm">Default post</div>
            <h2>Building a Professional WordPress Portfolio in 2026</h2>
            <p>A practical starting point for turning a portfolio into a fast, editable WordPress presence.</p>
            <span class="see-all">Create posts in WordPress →</span>
          </article>
        <?php endif; ?>
      </div>
    </section>
  </div>
</section>

<!-- ============ CONTACT ============ -->
<section class="page" id="page-contact">
  <div class="container">
    <section class="hero">
      <div>
        <div class="eyebrow" data-anim="fade-up">Contact</div>
        <h1 class="display" data-anim="fade-up" data-anim-delay="80">Let's build <span class="gradient-text">together</span>.</h1>
        <p class="lead" data-anim="fade-up" data-anim-delay="160">Tell me about your project, timeline and budget — I typically reply within 24 hours.</p>

        <div class="contact-list">
          <div class="contact-item glass" data-anim="fade-up"><div class="icon-badge sm">✉</div><div><div class="eyebrow sm">Email</div><div>hello@yousufzai.dev</div></div></div>
          <div class="contact-item glass" data-anim="fade-up" data-anim-delay="80"><div class="icon-badge sm">💬</div><div><div class="eyebrow sm">Discord</div><div>@yousufzai</div></div></div>
          <div class="contact-item glass" data-anim="fade-up" data-anim-delay="160"><div class="icon-badge sm">📍</div><div><div class="eyebrow sm">Based in</div><div>Lisbon, Portugal</div></div></div>
        </div>

        <img src="<?php echo customtheme_asset( 'contact-3d.jpg' ); ?>" alt="Purple envelope" class="contact-img float" data-anim="scale-in" />
      </div>

      <form class="form glass" id="contactForm" data-anim="fade-up">
        <label><span class="eyebrow sm">Your name</span><input name="name" placeholder="Ada Lovelace" required /></label>
        <label><span class="eyebrow sm">Email</span><input name="email" type="email" placeholder="ada@studio.com" required /></label>
        <label><span class="eyebrow sm">Project type</span><input name="type" placeholder="Custom theme, headless build, WooCommerce..." /></label>
        <label><span class="eyebrow sm">Budget</span><input name="budget" placeholder="$5k — $25k" /></label>
        <label><span class="eyebrow sm">Tell me about it</span><textarea name="message" rows="5" required placeholder="What are you dreaming up?"></textarea></label>
        <button type="submit" class="btn btn-primary" id="submitBtn">✈ Send message</button>
      </form>
    </section>
  </div>
</section>

</main>

<?php get_footer(); ?>
