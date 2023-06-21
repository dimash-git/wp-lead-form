<div class="lead">
  <div class="lead__tooltip">
    <div>Order Sneakers</div>
    <span><svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 8L2.54292e-07 2.70245e-07L14 -9.53674e-07L7 8Z" fill="#C10707"/></svg></span>
  </div>
  <h3>Available for Pre-Order!</h3>
  <ul>
    <li>30-50% cheaper than stores</li>
    <li>Certificate of authenticity</li>
    <li>Pay 50% upfront, the rest when the product arrives</li>
    <li>Assistance with size or model selection</li>
  </ul>
  <form class="lead__form" method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <!-- IMPORTANT -->
    <input type="hidden" name="action" value="add_lead">
    <?php wp_nonce_field('add_lead', 'cpt_nonce'); ?>
    <!-- IMPORTANT -->

    <input type="hidden" name="user_agent" value="<?php echo esc_attr($_SERVER['HTTP_USER_AGENT']); ?>">
    <input type="hidden" name="ip_address" value="<?php echo esc_attr($_SERVER['REMOTE_ADDR']); ?>">
    <input type="hidden" name="url" value="<?php global $wp; echo home_url($wp->request); ?>">

    <h4>Calculate the Cost in 5 Minutes</h4>
    <div class="input-wrapper">
      <input type="text" name="model" id="model" placeholder="Sneaker Model Name*" required />
    </div>
    <div class="input-wrapper">
      <input type="phone" name="phone" id="phone" placeholder="Phone Number*" required />
    </div>
    <button type="submit">Get Calculation on Phone</button>
  </form>
  <div class="lead__helper">
    <a href="#">How does it work?</a>
    <svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.3536 4.35355C10.5488 4.15829 10.5488 3.84171 10.3536 3.64645L7.17157 0.464466C6.97631 0.269204 6.65973 0.269204 6.46447 0.464466C6.2692 0.659728 6.2692 0.976311 6.46447 1.17157L9.29289 4L6.46447 6.82843C6.2692 7.02369 6.2692 7.34027 6.46447 7.53553C6.65973 7.7308 6.97631 7.7308 7.17157 7.53553L10.3536 4.35355ZM0 4.5H10V3.5H0V4.5Z" fill="#111111"/></svg>
  </div>
</div>

<script>
  document.querySelector(".lead__form").addEventListener("submit", async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const formAction = this.getAttribute("action");

    const response = await fetch(formAction, {
      method: 'post',
      body: formData
    });

    if (!response.ok) {
      throw new Error(`An error has occurred: ${response.status}`);
    }

    const data = await response.json();
    const { message } = data

    if (message && message === "success") {
      const div = document.createElement('div');
      div.classList.add('lead__message-success');
      div.textContent = 'Thank you! Your request has been successfully submitted';
      this.innerHTML = '';
      this.appendChild(div);
      return;
    }

    console.log(data);

  });
</script>
