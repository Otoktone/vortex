import React, { useState } from "react";

function MyModal() {
  const [showModal, setShowModal] = useState(false);

  const handleModal = () => {
    // onclick check state modal
    setShowModal(!showModal);
  };

  return (
    <>
        <a href="#" onClick={handleModal}>
                <i className="fa-solid fa-gear"></i><span>Customize</span>
        </a>
        {showModal && (
        <div className="modal-overlay">
          <div className="modal-content">
            <p>Custom your feed : </p>
            <button onClick={handleModal}>Close</button>
          </div>
        </div>
      )}
    </>
  );
}

export default MyModal;