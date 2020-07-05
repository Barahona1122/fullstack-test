<template>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="create_modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Product</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frmCreateElement">
          <div class="row p-2" v-if="list_error.length > 0" v-for="error in list_error">
            <div class="alert alert-danger" role="alert">
              {{error}}
            </div>
          </div>
          <div class="row">

            <div class="col-sm">
              <label>Name</label>
              <div class="form-group">
                  <div class='input-group'>
                    <input type="text" v-model="name" class="form-control">
                  </div>
              </div>                
            </div>
          </div>

          <div class="row">
            <div class="col-sm">
              <label>Description</label>
              <div class="form-group">
                  <div class='input-group'>
                    <textarea v-model="description" class="form-control" rows="3"></textarea>
                  </div>
              </div>                
            </div>
          </div>

          <div class="row">
            <div class="col-sm">
              <label>Price</label>
              <div class="form-group">
                  <div class='input-group'>
                    <input type="number" v-model="price" class="form-control">
                  </div>
              </div>                
            </div>
          </div>

          <div class="row">
            <div class="col-sm">
              <label>Slug</label>
              <div class="form-group">
                  <div class='input-group'>
                    <input type="text" v-model="slug" class="form-control">
                  </div>
              </div>                
            </div>
          </div>

          <div class="row">
            <div class="col-sm">
              <input type="file" name="" class="form-control" id="cover">
            </div>
          </div>          
          
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fa fa-close"></i> Close
        </button>
        <button type="button" class="btn btn-primary" @click="CreateProduct">
           Save 
        </button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
    export default {
        props:['list_error'],
        data(){
          return{
              name: ''
            , description: ''
            , price: ''
            , slug: ''
          }
        },

        methods:{

          CreateProduct(){         

            this.$emit('CreateProduct', this.name
                                      , this.description
                                      , this.price
                                      , this.slug
                                    );
          },

        }
        
    }
</script>
