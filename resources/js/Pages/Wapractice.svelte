<script>

</script>

<main>
    <h2>Button Variants</h2>
    <wa-button>Default</wa-button>
    <wa-button variant="brand">Brand</wa-button>
    <wa-button variant="success">Success</wa-button>
    <wa-button variant="warning">Warning</wa-button>
    <wa-button variant="danger">Danger</wa-button>
    <h2>Button Appearances</h2>
    <wa-button variant="brand" appearance="filled">Filled</wa-button>
    <wa-button variant="brand" appearance="outlined">Filled</wa-button>
    <wa-button variant="brand" appearance="text">Filled</wa-button>
    <h2>Button Sizes</h2>
    <wa-button size="small">small</wa-button>
    <wa-button size="large">large</wa-button>
    <h2>Button States</h2>
    <wa-button disabled="disabled">Disabled</wa-button>
    <wa-button loading>Loading</wa-button>
    <wa-button pill>Pill</wa-button>
    <h2>Button Icons</h2>
    <wa-button>
        <wa-icon slot="start" name="gear"></wa-icon>
        Settings
    </wa-button>
    <wa-button>
        Next
        <wa-icon start="end" name="arrow-right"></wa-icon>
    </wa-button>
    <h2>Button as a link</h2>
    <wa-button href="https://example.com" target="_blank">Open Link</wa-button>

    <h2>Form Inputs</h2>
    <wa-input label="Username" name="username" placeholder="Enter username" required></wa-input>
    <wa-input label="Email" name="email" type="email"></wa-input>
    <wa-input label="Password" name="password" type="password"></wa-input>




    <wa-tab-group>
  <wa-tab slot="nav" panel="general">General</wa-tab>
  <wa-tab slot="nav" panel="settings">Settings</wa-tab>
  <wa-tab slot="nav" panel="advanced">Advanced</wa-tab>

  <wa-tab-panel name="general">General settings here.</wa-tab-panel>
  <wa-tab-panel name="settings">Settings content here.</wa-tab-panel>
  <wa-tab-panel name="advanced">Advanced options here.</wa-tab-panel>


  <wa-breadcrumb>
  <wa-breadcrumb-item href="/">Home</wa-breadcrumb-item>
  <wa-breadcrumb-item href="/blog">Blog</wa-breadcrumb-item>
  <wa-breadcrumb-item>Current Post</wa-breadcrumb-item>
</wa-breadcrumb>
</wa-tab-group>


<wa-tree>
  <wa-tree-item>
    Documents
    <wa-tree-item>Resume.pdf</wa-tree-item>
    <wa-tree-item>Cover Letter.pdf</wa-tree-item>
  </wa-tree-item>
  <wa-tree-item>Photos</wa-tree-item>
</wa-tree>


<wa-progress-bar value="60"></wa-progress-bar>
<wa-progress-ring value="75"></wa-progress-ring>
<wa-spinner></wa-spinner>
<wa-skeleton effect="sheen"></wa-skeleton>

<wa-carousel navigation pagination>
  <wa-carousel-item><img src="slide1.jpg" alt="Slide 1" /></wa-carousel-item>
  <wa-carousel-item><img src="slide2.jpg" alt="Slide 2" /></wa-carousel-item>
  <wa-carousel-item><img src="slide3.jpg" alt="Slide 3" /></wa-carousel-item>
</wa-carousel>


<!-- QR Code -->
<wa-qr-code value="https://example.com"></wa-qr-code>

<!-- Copy Button -->
<wa-copy-button value="Text to copy"></wa-copy-button>

<!-- Collapsible Details -->
<wa-details summary="Click to expand">
  Hidden content revealed here.
</wa-details>

<!-- Callout -->
<wa-callout variant="warning">
  This is an important warning message.
</wa-callout>

<!-- Divider -->
<wa-divider></wa-divider>

<!-- Split Panel (resizable) -->
<wa-split-panel>
  <div slot="start">Left panel</div>
  <div slot="end">Right panel</div>
</wa-split-panel>

<!-- Before/After Comparison -->
<wa-comparison>
  <img slot="before" src="before.jpg" alt="Before" />
  <img slot="after" src="after.jpg" alt="After" />
</wa-comparison>
Layout Utility Classes
Web Awesome includes layout utilities (no Tailwind needed):

<!-- Vertical stack with gap -->
<div class="wa-stack wa-gap-m">
  <div>Item 1</div>
  <div>Item 2</div>
</div>

<!-- Horizontal row (wraps) -->
<div class="wa-cluster wa-gap-s">
  <wa-button>A</wa-button>
  <wa-button>B</wa-button>
  <wa-button>C</wa-button>
</div>

<!-- Auto grid -->
<div class="wa-grid wa-gap-m">
  <wa-card>Card 1</wa-card>
  <wa-card>Card 2</wa-card>
  <wa-card>Card 3</wa-card>
</div>

<!-- Split two items apart -->
<div class="wa-split">
  <span>Left</span>
  <span>Right</span>
</div>

<p class="wa-heading-xl">Large Heading</p>
<p class="wa-heading-m">Medium Heading</p>
<p class="wa-body-m">Body text</p>
<p class="wa-caption-s">Small caption</p>


</main>

<style>
    main{
        padding: 20px;
    }
</style>