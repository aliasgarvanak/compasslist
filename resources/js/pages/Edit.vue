<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Edit Post : {{this.$route.params.id}}</div>

          <div class="card-body">
              <div class="alert alert-dismissible"  :class="alert_class" v-if="show"> 
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ this.message }} 
              </div>
            <form @submit.prevent="updatePost">
                <div class="form-group">
                    <label for="name">Post Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Post name" v-model="name">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea v-model="description" class="form-control" id="description"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Update</button>
                </div>
            </form>

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
            name : "",
            description : "",
            message : "",
            show : false,
            alert_class : ''
        }
    },
    methods : {
        getPostDetail()
        {
           axios.get('/api/post/'+this.$route.params.id)
               .then(
                response => {
                    if(response.status == 200)
                    {
                        this.name = response.data.post.name;
                        this.description = response.data.post.description;
                    }
                }
            )
            .catch(error=>{
                this.message = response.data.message;
                this.show = true;
                this.alert_class = 'alert-danger';
            });

        },

        updatePost()
        {
            if(this.name == '' || this.description == '')
            {
                alert('Both fields are required');
                return false;
            }
            axios.post('http://127.0.0.1:8000/api/post/'+this.$route.params.id,{
                _method : "put",
                name : this.name,
                description : this.description
            })
            .then(
                response => {
                    this.message = response.data.message;
                    this.show = true;
                    if(response.data.class == 'success')
                    {
                        //this.$router.push({name: 'home'})
                        this.alert_class = 'alert-success';
                        setTimeout(()=>{
                        this.$router.push({name: 'home'})
                        },3000);
                    }
                    else{
                       // this.message = response.data.message;
                        //this.show = true;
                         this.alert_class = 'alert-danger';
                    }
                }
            )
            .catch(error=>{
                this.message = response.data.message;
                this.show = true;
                this.alert_class = 'alert-danger';
            });
        }
    },
    created(){
        this.getPostDetail();
    }
}
</script>