import React from 'react';

// api url (develop)(TODO : change with env varibale)
const apiUrl = 'http://localhost:80/api/feed/articles';

class FeedArticles extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      articles: [],
      selectedArticle: null,
      showModal: false
    };
  }
  // init state
  // state = {
  //   articles: []
  // };

  // wait until component is mounted
  async componentDidMount() {
    try {
      // fetch articles
      const res = await fetch(apiUrl);
      // extract data from response
      const data = await res.json();
      // update state with articles
      this.setState({ articles: data });
    } catch (error) {
      console.error(error);
    }
  }

  openModal = (article) => {
    this.setState({ selectedArticle: article, showModal: true });
  }

  closeModal = () => {
    this.setState({ selectedArticle: null, showModal: false });
  }

  render() {
    // populate state with articles from fetch call
    const { articles, selectedArticle, showModal } = this.state;

    return (
      <div className="feedContainer">
        {articles.map(article => (
          <div className="feedItem" key={article.id} onClick={() => this.openModal(article)}>
            <div>
              <div className="feedTitle">
                <p>{article.category[0].toUpperCase() + article.category.substr(1).toLowerCase()}</p>
                <h3>{article.title[0].toUpperCase() + article.title.substr(1).toLowerCase().slice(0, 100)}...</h3>
              </div>
              <div className="feedImage">
                <img src={article.media || 'build/images/icons/favicon.png'} alt={article.title} />
              </div>
              <div className="feedContent">
                <p>{article.content.slice(0, 100)}...</p>
              </div>
              <div className="feedDateContainer">
                <div className="feedDate">{article.date}</div>
              </div>
            </div>
          </div>
        ))}

        {selectedArticle && showModal && (
          <div className="modal">
            <div className="modalContent">
              <div className="modalTitle">
                <p>{selectedArticle.category[0].toUpperCase() + selectedArticle.category.substr(1).toLowerCase()}</p>
                <h3>{selectedArticle.title[0].toUpperCase() + selectedArticle.title.substr(1).toLowerCase()}</h3>
              </div>
              <div className="modalImage">
                <img src={selectedArticle.media || 'build/images/icons/favicon.png'} alt={selectedArticle.title} />
              </div>
              <div className="">
                <p>{selectedArticle.content}</p>
              </div>
              <div className="modalDateContainer">
                <div className="modalDate">{selectedArticle.date}</div>
              </div>
              <div className="modalLink">
                <a className="home_button" href={selectedArticle.link} target="_blank"><i className="fa-solid fa-external-link"></i> Open article</a>
                <span className="home_button"><i className="fa-solid fa-bookmark"></i> Add to bookmars</span>
              </div>
              <span className="close" onClick={this.closeModal}>&times;</span>
            </div>
          </div>
        )}
      </div>
    );
  }
}

export default FeedArticles;
