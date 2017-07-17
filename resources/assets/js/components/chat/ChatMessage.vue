<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Chat Component</div>

                    <div class="panel-body">
                        I'm a Chat Message! Again bro. Sema Jo
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: {
            form: new Form({
                name: 'nik',
                description: 'msg here'
            })
        },
        created() {
            //post form data
            this.form.post('/project/create')
            .then(data => console.log(data))
            .catch(error => console.log(error));
        }
    }
</script>
