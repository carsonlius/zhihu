<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <span style="font-weight: bold;">创建角色</span>
            <span class="pull-right"><a href="/Role" class="btn btn-xs btn-info">角色列表</a></span>
        </div>
        <div class="panel-body">
            <sweet-modal :icon="icon_type" ref="modal_prompt" overlay-theme="dark" modal-theme="dark">
                <p style="white-space: pre-line">{{ msg_response }}</p>
                <button v-on:click="closeModel()" class="btn btn-primary pull-right">确认</button>
            </sweet-modal>
            <div class="form-horizontal">
                <div class="form-group">
                    <span v-show="errors.has('name')" class="alert-danger">{{ errors.first('name') }}</span>
                    <label for="name" class="col-sm-2 control-label">角色名称</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="name" data-vv-as="角色名称"
                               v-validate.initial="'required'" data-vv-name="name" v-model="name">
                    </div>
                </div>
                    <div class="form-group">
                        <span v-show="errors.has('slug')" class="alert-danger">{{ errors.first('slug') }}</span>
                        <label for="slug" class="col-sm-2 control-label">Slug</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="slug" v-model="slug" data-vv-as="唯一标识"
                                   v-validate.initial="'required'" id="slug">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="slug" class="col-sm-2 control-label">描述</label>
                        <div class="col-sm-6">
                            <textarea v-model="description" class="form-control" data-vv-name="description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">级别</label>
                        <div class="col-sm-6">
                            <v-select :options="list_level" v-model="level" :placeholder="placeholder_level"></v-select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8">
                            <button class="btn btn-primary  btn-sm pull-right" @click.prevent="createRole">提交</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    import { SweetModal, SweetModalTab } from 'sweet-modal-vue';
    export default {
        name: "RoleCreate",
        data: function () {
            return {
                msg_response : '',
                icon_type : 'success',

                name: '',
                slug: '',
                description: '',
                level: {label: '1', value: 1},
                list_level: [
                        {label: '1', value: 1},
                        {label: '2', value: 2},
                        {label: '3', value: 3},
                        {label: '4', value: 4},
                ],
                placeholder_level : '级别'
            }
        },
        methods: {
            // 关闭模态框
            closeModel : function(){
                this.$refs.modal_prompt.close();

                // 创建成功则跳转到列表
                if (this.icon_type === 'success') {
                    window.location.replace('/Role');
                }
            },

            // 新建角色
            createRole: function () {
                let params = {
                    name: this.name,
                    slug: this.slug,
                    description: this.description,
                    level: this.level.value
                };
                let url = '/api/role';

                // 存储角色
                let vm = this;
                this.$http.post(url, params, {responseType: 'json'}).then(function (response) {
                    if (response.body.status === 0) {
                        vm.msg_response = '角色"' + vm.name +'" 创建成功';
                    } else {
                      vm.msg_response = response.body.msg;
                      vm.icon_type = 'error';
                    }
                    vm.$refs.modal_prompt.open();
                });
            }
        }
    }
</script>

<style scoped>

</style>