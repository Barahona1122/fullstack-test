<template>
    <div class="modal fade" id="destroy_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header flat" style="color: white;background: #ab1010;">
                 <h5>Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <div id="delete-alert" class="alert flat" style="display:none">
                                <div id="delete-alert-content"></div>
                            </div>
                        </div>
                    </div>
                    <h5 class="text-center">
                        ¿You want to delete: 
                            <strong class="text-info">{{name}}</strong>
                        ?
                    </h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" @click="ConfirmDestroyUser">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['user_id','name'],

        methods:{

          ConfirmDestroyUser(){
            this.$emit('ConfirmDestroyUser', this.user_id);
          },

        }
        
    }
</script>