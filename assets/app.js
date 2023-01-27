/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/global.scss';

// start the Stimulus application
import './bootstrap';

// REACT
// import React from 'react';
// import ReactDOM from 'react-dom/client';
// import Home from './js/components/Home';  // import the Home component
// import { Vortex } from 'react-loader-spinner';

// const root = ReactDOM.createRoot(document.getElementById('root'));  // create a root element
// root.render(<Home />);  // render the Home component to the root element
// root.render(<Vortex />)

import './js/front/register.ts';
