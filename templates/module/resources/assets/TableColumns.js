export default [
  {
    "data": "id",
    "name": "id",
    "title": "标签ID"
  },
  {
    "data": "name",
    "name": "name",
    "title": "标签名称"
  },
  {
    "data": "creator",
    "name": "creator",
    "title": "创建人",
    "searchable": false,
    "render": function (data) {
      if (data) {
        return data.name;
      }
      return '';
    }
  },
  {
    "data": "count",
    "name": "count",
    "title": "使用次数"
  },
  {
    "data": "created_at",
    "name": "created_at",
    "title": "创建时间"
  }
];