<template>
  <div>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>标签管理
        <small v-if="item.id">编辑标签</small>
        <small v-else>新增标签</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <router-link to="/"><i class="fa fa-dashboard"></i> 总览</router-link>
        </li>
        <li>
          <router-link to="/tag">标签管理</router-link>
        </li>
        <li class="active" v-if="item.id">编辑标签</li>
        <li class="active" v-else>新增标签</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="box box-primary">
        <!--<div class="box-header with-border">-->
        <!--</div>-->
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">

          <form class="form-horizontal" @submit="onSave">
            <div class="form-group" v-if="item.id">
              <label for="field-id" class="col-sm-2 control-label">标签ID</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="field-id" v-bind:value="item.id" disabled>
              </div>
            </div>
            <div class="form-group" v-if="item.id">
              <label for="field-creator.name" class="col-sm-2 control-label">创建人</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="field-creator.name" v-bind:value="item.creator?item.creator.name:''"
                       disabled>
              </div>
            </div>
            <div class="form-group" :class="{'has-error': item.$errors.has('name')}">
              <label for="field-name" class="col-sm-2 control-label">名字</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="field-name" v-model="item.name">
                <span class="help-block" v-if="item.$errors.has('name')">{{item.$errors.get('name')}}</span>
              </div>
            </div>
            <div class="form-group" v-if="item.id">
              <label for="field-count" class="col-sm-2 control-label">使用次数</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="field-count" v-bind:value="item.count" disabled>
              </div>
            </div>
            <div class="form-group" v-if="item.id">
              <label for="field-created_at" class="col-sm-2 control-label">创建时间</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="field-created_at" v-bind:value="item.created_at" disabled>
              </div>
            </div>
            <!-- 暂时不需要编辑以下内容 -->
            <!--<div class="form-group" :class="{'has-error': item.$errors.has('parent_id')}">-->
            <!--<label for="field-parent_id" class="col-sm-2 control-label">父级标签</label>-->
            <!--<div class="col-sm-10">-->
            <!--<v-select class="form-control" id="field-parent_id" style="width: 100%;"-->
            <!--placeholder="请选择父级标签"-->
            <!--v-model="item.parent_id" :options="[]">-->
            <!--</v-select>-->
            <!--<span class="help-block" v-if="item.$errors.has('parent_id')">{{item.$errors.get('parent_id')}}</span>-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="form-group" :class="{'has-error': item.$errors.has('lft')}">-->
            <!--<label for="field-lft" class="col-sm-2 control-label">左标签</label>-->
            <!--<div class="col-sm-10">-->
            <!--<v-select class="form-control" id="field-lft" style="width: 100%;"-->
            <!--placeholder="请选择左标签"-->
            <!--v-model="item.lft" :options="[]">-->
            <!--</v-select>-->
            <!--<span class="help-block" v-if="item.$errors.has('lft')">{{item.$errors.get('lft')}}</span>-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="form-group" :class="{'has-error': item.$errors.has('rgt')}">-->
            <!--<label for="field-rgt" class="col-sm-2 control-label">右标签</label>-->
            <!--<div class="col-sm-10">-->
            <!--<v-select class="form-control" id="field-rgt" style="width: 100%;"-->
            <!--placeholder="请选择右标签"-->
            <!--v-model="item.rgt" :options="[]">-->
            <!--</v-select>-->
            <!--<span class="help-block" v-if="item.$errors.has('rgt')">{{item.$errors.get('rgt')}}</span>-->
            <!--</div>-->
            <!--</div>-->
            <!--<div class="form-group" :class="{'has-error': item.$errors.has('depth')}">-->
            <!--<label for="field-depth" class="col-sm-2 control-label">深度</label>-->
            <!--<div class="col-sm-10">-->
            <!--<input type="number" class="form-control" id="field-depth" v-model="item.depth">-->
            <!--<span class="help-block" v-if="item.$errors.has('depth')">{{item.$errors.get('depth')}}</span>-->
            <!--</div>-->
            <!--</div>-->

          </form>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <router-link-back class="btn btn-lg btn-flat btn-default pull-left">返回</router-link-back>
          <button type="submit" form="editing-form" class="btn btn-lg btn-flat btn-primary" @click="onSave"
                  :disabled="saving">
            {{saving?"保存中...":"保存"}}
          </button>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
</template>

<script type="javascript">
  import {Vue} from 'resources/assets/js/commons/vuejs.js';
  import {alert} from 'resources/assets/js/components/SweetAlertDialogs';
  import ErrorsBuilder from 'resources/assets/js/commons/ErrorsBuilder.js';

  var resourceURL = "/tag";
  var resource = Vue.resource(resourceURL + '{/id}?_with=creator');
  // var resource = Vue.resource(resourceURL + '{/id}?_with=permissions,roles'); // 载入额外的关联数据(relationships)
  var vueConfig = {
    data: function () {
      var data = {
        item: {
          "id": null,
          "slug": "",
          "name": "",
          "description": null,
          "suggest": 0,
          "count": 0
          // "parent_id": null,
          // "lft": null,
          // "rgt": null,
          // "depth": null
        },
        saving: false
      };
      data.item.$errors = ErrorsBuilder();
      return data;
    },
    beforeRouteEnter (to, from, next) {
      if (to.params.id) {
        resource.get({id: to.params.id}).then(function (result) {
          next(function (vm) {
            vm.item = result.data.data;
            vm.item.$errors = ErrorsBuilder();
          });
        }).catch(function (err) {
          next(false);
        });
      }
      else {
        next();
      }
    },
    methods: {
      onSave: function (event) {
        this.saving = true;
        this.item.$errors.removeAll();

        var promise = null;
        let payload = $.extend(true, {}, this.item);
        if (payload.id) {
          promise = resource.update({id: payload.id}, payload).then(function (result) {
            window.toastr["success"]("编辑已保存");
            return result.data.data;
          });
        }
        else {
          promise = resource.save(payload).then(function (result) {
            window.toastr["success"]("新增成功");
            return result.data.data;
          });
        }

        promise.then(function (data) {
          return resource.get({id: data.id});
        }).then(function (result) {
          this.saving = false;
          this.item = result.data.data;
          this.item.$errors = ErrorsBuilder();
        }.bind(this)).catch(function (err) {
          this.saving = false;
          if (err.status == 422) {
            this.item.$errors.setAll(err.body);
            this.item.$errors.focusFirstErrorField();
          }
          else {
            alert(err.data.message);
          }
        }.bind(this));

        return false;
      },
    }
  };
  export default vueConfig;

</script>

<style lang="scss">

</style>
