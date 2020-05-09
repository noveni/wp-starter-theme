import 'styles/theme/_main.scss';
import './assets'

import { ecrannoirDomReady } from 'scripts/utils/dom';
import Router from 'scripts/utils/Router';


import common from './routes/common';
import home from './routes/home'


/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
});
ecrannoirDomReady(() => routes.loadEvents())
