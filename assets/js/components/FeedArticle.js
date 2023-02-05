import axios from 'axios';
import React from 'react';

const apiUrl = 'http://localhost:80/api/feed/articles';

class FeedArticles extends React.Component {
  state = {
    articles: []
  };

  async componentDidMount() {
    try {
      const res = await axios.get(apiUrl);
      this.setState({ articles: res.data });
    } catch (error) {
      console.error(error);
    }
  }

  render() {
    const { articles } = this.state;

    return (
      <div className="feedContainer">
        {articles.map(article => (
          <div className="feedItem" key={article.id}>
            <a href={article.link} target="_blank">
              <div className="feedTitle">
                <p>{article.category}</p>
                <h3>{article.title}</h3>
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