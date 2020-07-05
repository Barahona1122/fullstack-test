<template>
  <div class="col-md-4 order-md-2 mb-4" v-if="fill_products.length > 0">
    <h4 class="d-flex justify-content-between align-items-center mb-3">
      <span class="text-muted">Your cart</span>
      <span class="badge badge-secondary badge-pill">
          {{ fill_products.length }}
      </span>
    </h4>
    <ul class="list-group mb-3">
      <li class="list-group-item d-flex justify-content-between lh-condensed" v-for="product in fill_products">
        <div>
          <h6 class="my-0">{{product.product.name}}</h6>
          <small class="text-muted">{{product.product.description.substring(0,40)+".." }}</small>
        </div>
        <span class="text-muted">{{ product.total }}</span>
      </li>

      <li class="list-group-item d-flex justify-content-between">
          <h3>
            <span>Total</span>
          </h3>
        <strong> $ {{ total }}</strong>
      </li>
    </ul>
  </div>
</template>
<script>

  export default {
    props:['fill_products','total'],
  }
</script>