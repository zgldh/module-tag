<template>
  <div class="tag-select-widget">
    <vue-select ref="vueselect" :multiple="true"
                :taggable="true"
                v-bind:value="value"
                label="name"
                :on-change="onChange"
                :options="tags"
                :on-search="onSearchTags">
    </vue-select>
    <div class="most-used-tags" v-if="showMostUsed">
      <span v-for="tag in mostUsedTags" v-on:click="onSelectTag(tag)">{{tag.name}}</span>
    </div>
  </div>
</template>

<script type="javascript">
  import vSelect from 'vue-select';
  import _ from 'lodash';

  export default {
    name: 'tag-select',
    components: {
      'vue-select': vSelect
    },
    props: {
      value: {
        default: null
      },
      showMostUsed: {
        type: Boolean,
        default: false
      },
    },
    data: function () {
      return {
        tags: [],
        mostUsedTags: []
      };
    },
    mounted: function () {
      if (this.showMostUsed) {
        var vm = this;
        this.$http.get('/tag/most-used').then(function (result) {
          vm.mostUsedTags = result.data.data;
        });
      }
    },
    methods: {
      onSelectTag: function (tag) {
        var existedTag = this.$refs.vueselect.value.find(function (item) {
          return item.id == tag.id;
        });
        if (!existedTag) {
          this.$refs.vueselect.value.push(tag);
        }
      },
      onChange: function (val) {
        this.$emit('input', val);
      },
      onSearchTags: _.debounce(function (search, loading) {
        loading(true)
        this.$http.get('/tag', {
          params: {
            draw: Date.now(),
            start: 0,
            length: 25,
            columns: [
              {data: 'id'},
              {data: 'name', searchable: true}
            ],
            search: {
              value: search,
              regex: false
            }
          }
        }).then(resp => {
          var newTags = _.forEach(resp.data.data, function (tag) {
            tag.value = tag.id;
          });
          this.tags = _.uniqWith(this.tags.concat(newTags), (a, b) => {
            return a.value == b.value
          });
          loading(false)
        });
      }, 500)
    }
  };
</script>

<style lang="scss">
  .tag-select-widget {
    border: none;
    padding: 0;
    height: auto;

    .most-used-tags {
      margin-top: 0.5em;
      span {
        color: #333;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 4px;
        height: 26px;
        margin: 4px 1px 0 3px;
        padding: 1px .25em;
        line-height: 24px;
        cursor: pointer;
      }
    }
  }
</style>
