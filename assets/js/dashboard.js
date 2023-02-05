// REACT
import React from 'react';
import ReactDOM from 'react-dom/client';
import FeedArticles from './components/FeedArticle'
const feed = ReactDOM.createRoot(document.getElementById('feed'));
feed.render(<FeedArticles />);
// ReactDOM.render(<FeedArticles />, document.getElementById('feed'));