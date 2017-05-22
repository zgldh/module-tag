export default [
  {path: '/tag', component: () => System.import('./AppPage.vue')},
  {path: '/tag/create', component: () => System.import('./EditorPage.vue')},
  {path: '/tag/:id/edit', component: () => System.import('./EditorPage.vue')},
];