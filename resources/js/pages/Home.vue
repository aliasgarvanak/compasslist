<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">All Posts</div>

          <div class="card-body">
              <div class="alert alert-dismissible"  :class="alert_class" v-if="show"> 
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ this.message }} 
              </div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post in posts" :key="post.id">
                        <td>{{post.id}}</td>
                        <td>{{post.name}}</td>
                        <td>{{post.description}}</td>
                        <td>{{post.created_at}}</td>
                        <td>
                            <a href="javascript::void(0);" @click="deletePost(post.id)">Delete</a>
                            <a href="javascript::void(0);" @click="editPost(post.id)">Edit</a>
                        </td>
                    
                    </tr>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    data: function(){
        return {
            posts : [],
            message : "",
            show : false,
            alert_class : ''
        }
    },
    methods : {
        getPosts()
        {
            axios.get('api/posts')
            .then(response => {
                this.posts = response.data.posts
            })
            .catch(error=>{
                 this.message = response.data.message;
                 this.show = true;
                 this.alert_class = 'alert-danger';
            })

        },
        deletePost: function(id) {
             if(confirm("Do you really want to delete?")){
                axios.post('api/post/'+id,{_method: 'delete'})
                .then(response => {
                       this.message = response.data.message;
                       this.show = true;
                       if(response.data.class == 'success')
                        {
                            this.alert_class = 'alert-success';
                        }
                       else{
                            this.alert_class = 'alert-danger';
                        }
                        this.posts = response.data.posts
                })
                .catch(error=>{
                   this.message = response.data.message;
                   this.show = true;
                   this.alert_class = 'alert-danger';
                })
                }
            },
        editPost: function(id)
        {
            this.$router.push({name:'edit',params:{id:id}})
        }
    },
    created(){
        this.getPosts();
    }
}
</script>