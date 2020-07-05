<template>
  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="edit_modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">User</h4>
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">

            <div class="col-sm">
              <label>Name</label>
              <div class="form-group">
                  <div class='input-group'>
                    <input type="text" class="form-control" v-model="name">
                  </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm">
              <label>Email</label>
              <div class="form-group">
                  <div class='input-group'>
                    <input type="text" name="hola" v-model="mail" class="form-control">
                  </div>
              </div>                
            </div>
          </div>

          <div class="row">
            <div class="col-sm">
              <label>Password</label>
              <div class="form-group">
                  <div class='input-group'>
                    <input type="password" class="form-control" autocomplete="off" v-model="password">
                  </div>
              </div>                
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" >
            <i class="fa fa-close"></i> Close
          </button>
          <button type="button" class="btn btn-primary" @click="UpdateUser()">
             Save 
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
    export default {
        props:['name','mail','user_id'],
        data(){
          return{
            password: '',
          }
        },

        watch:{
          name(){
          }
        },

        methods:{

          UpdateUser(){
            this.$emit('UpdateUser', this.user_id, this.mail, this.name, this.password);
          },

        }
        
    }
</script>