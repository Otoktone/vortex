import axios from 'axios';
import React from 'react';

// api url (develop)(TODO : change with env varibale)
const apiUrl = 'http://localhost:80/api/feed/articles';

class FeedArticles extends React.Component {
  // init state
  state = {
    articles: []
  };

  // wait until component is mounted
  async componentDidMount() {
    try {
      // axios client request
      const res = await axios.get(apiUrl);
      // update state with articles
      this.setState({ articles: res.data });
    } catch (error) {
      console.error(error);
    }
  }

  render() {
    // populate state with articles from axios call
    const { articles } = this.state;

    return (
      <div className="feedContainer">
        {/* create each article from articles */}
        {articles.map(article => (
          <div className="feedItem" key={article.id}>
            <a href={article.link} target="_blank">
              <div className="feedTitle">
                <p>{article.category[0].toUpperCase() + article.category.substr(1).toLowerCase()}<i className="fa-solid fa-bookmark"></i></p>
                <h3>{article.title[0].toUpperCase() + article.title.substr(1).toLowerCase()}</h3>
              </div>
              <div className="feedImage">
                <img src={article.media || 'build/images/icons/favicon.png'} alt={article.title} />
              </div>
              <div className="feedContent">
                <p>{article.content.slice(0,100)}...</p>
              </div>
              <div className="feedDateContainer">
                <div className="feedDate">{article.date}</div>
              </div>
            </a>
          </div>
        ))}
      </div>
    );
  }
}

export default FeedArticles;