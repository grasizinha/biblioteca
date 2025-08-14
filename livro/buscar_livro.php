
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Busca e Cadastro de Livros</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    margin: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 2rem;
    color: #fff;
  }

  .container {
    background: rgba(255 255 255 / 0.15);
    border-radius: 12px;
    padding: 1.5rem 2rem;
    max-width: 600px;
    width: 100%;
    box-shadow: 0 12px 24px rgba(118, 75, 162, 0.6);
    backdrop-filter: blur(10px);
  }

  h1 {
    margin: 0 0 1rem;
    font-weight: 600;
    text-align: center;
    letter-spacing: 0.05em;
  }

  input[type="search"] {
    width: 100%;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    border: none;
    outline: none;
    font-size: 1.1rem;
    margin-bottom: 1rem;
    background-color: rgba(255 255 255 / 0.25);
    color: #fff;
    transition: background-color 0.3s ease;
  }

  input[type="search"]:focus {
    background-color: rgba(255 255 255 / 0.4);
    box-shadow: 0 0 10px #764ba2;
  }

  .results {
    list-style: none;
    padding: 0;
    margin: 0;
    max-height: 400px;
    overflow-y: auto;
  }

  .book {
    display: flex;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 10px;
    padding: 12px;
    margin-bottom: 12px;
    align-items: center;
    transition: background-color 0.3s;
  }

  .book:hover {
    background-color: rgba(0, 0, 0, 0.45);
  }

  .book img {
    width: 60px;
    height: auto;
    border-radius: 6px;
    flex-shrink: 0;
    margin-right: 16px;
  }

  .book-info {
    flex: 1;
  }

  .book-title {
    font-weight: 600;
    font-size: 1rem;
    margin: 0 0 6px;
    color: #ffd700;
  }

  .book-authors {
    margin: 0;
    font-size: 0.9rem;
    color: #ddd;
    margin-bottom: 6px;
  }

  .save-btn {
    background-color: #764ba2;
    border: none;
    color: #f0f0f5;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 6px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
    user-select: none;
  }

  .save-btn:hover:enabled {
    background-color: #667eea;
  }

  .save-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }

  .message {
    margin-top: 1rem;
    font-weight: 600;
    text-align: center;
    padding: 0.75rem;
    border-radius: 8px;
    user-select: none;
  }

  .message.success {
    background-color: #2ecc71;
    color: white;
  }

  .message.error {
    background-color: #e74c3c;
    color: white;
  }

  .no-results {
    text-align: center;
    margin-top: 2rem;
    color: #eee;
    font-style: italic;
  }
</style>
</head>
<body>
  <div class="container" role="main">
    <h1>Busca e Cadastro de Livros</h1>
    <input type="search" id="searchInput" placeholder="Digite o título, autor ou ISBN..." aria-label="Busca de livros" autocomplete="off" />
    <ul class="results" id="resultsList"></ul>
    <p class="no-results" id="noResults" style="display:none;">Nenhum resultado encontrado.</p>
    <div id="messageBox"></div>
  </div>

<script>
  (() => {
    const input = document.getElementById('searchInput');
    const resultsList = document.getElementById('resultsList');
    const noResults = document.getElementById('noResults');
    const messageBox = document.getElementById('messageBox');

    let timeoutId = null;

    function showMessage(text, type = 'success') {
      messageBox.innerHTML = '';
      const div = document.createElement('div');
      div.className = 'message ' + (type === 'success' ? 'success' : 'error');
      div.textContent = text;
      messageBox.appendChild(div);
      setTimeout(() => {
        messageBox.innerHTML = '';
      }, 4000);
    }

    input.addEventListener('input', () => {
      clearTimeout(timeoutId);
      resultsList.innerHTML = '';
      noResults.style.display = 'none';
      messageBox.innerHTML = '';

      const query = input.value.trim();
      if (query.length < 3) {
        return;
      }

      timeoutId = setTimeout(() => {
        fetchBooks(query);
      }, 500);
    });

    async function fetchBooks(query) {
      const url = `https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(query)}&maxResults=10`;

      resultsList.innerHTML = '';
      noResults.style.display = 'none';

      try {
        const response = await fetch(url);
        if (!response.ok) throw new Error('Falha na requisição');

        const data = await response.json();

        if (!data.items || data.items.length === 0) {
          noResults.style.display = 'block';
          return;
        }

        for (const item of data.items) {
          const volumeInfo = item.volumeInfo;
          const thumbnail = volumeInfo.imageLinks ? volumeInfo.imageLinks.thumbnail : 'https://via.placeholder.com/60x90?text=Sem+Capa';
          const title = volumeInfo.title || 'Título desconhecido';
          const authors = volumeInfo.authors ? volumeInfo.authors.join(', ') : 'Autor desconhecido';

          // Google Books API does not provide a separate ISBN field always.
          // We try to find the ISBN_13 in industryIdentifiers if available, else fallback to empty string
          let isbn = '';
          if (volumeInfo.industryIdentifiers) {
            const isbn13 = volumeInfo.industryIdentifiers.find(id => id.type === 'ISBN_13');
            const isbn10 = volumeInfo.industryIdentifiers.find(id => id.type === 'ISBN_10');
            if (isbn13) isbn = isbn13.identifier;
            else if (isbn10) isbn = isbn10.identifier;
          }

          const li = document.createElement('li');
          li.className = 'book';
          li.innerHTML = `
            <img src="${thumbnail}" alt="Capa do livro ${title}" loading="lazy"/>
            <div class="book-info">
              <p class="book-title">${title}</p>
              <p class="book-authors">${authors}</p>
              <button class="save-btn" type="button">Salvar Livro</button>
            </div>
          `;

          const saveBtn = li.querySelector('.save-btn');
          saveBtn.addEventListener('click', () => saveBook(title, authors, isbn, saveBtn));
          resultsList.appendChild(li);
        }
      } catch (error) {
        resultsList.innerHTML = `<li class="no-results">Erro ao buscar livros. Tente novamente mais tarde.</li>`;
      }
    }

    async function saveBook(title, authors, isbn, button) {
      button.disabled = true;
      button.textContent = 'Salvando...';
      messageBox.innerHTML = '';

      // Some basic validation, title and author required.
      if (!title || !authors || !isbn) {
        showMessage('Não foi possível salvar o livro: faltam dados importantes.', 'error');
        button.disabled = false;
        button.textContent = 'Salvar Livro';
        return;
      }

      // Normalize ISBN: remove dashes and spaces
      const isbnNormalized = isbn.replace(/[-\s]/g, '');

      try {
        const formData = new URLSearchParams();
        formData.append('titulo', title);
        formData.append('autor', authors);
        formData.append('isbn', isbnNormalized);

        const response = await fetch('./criar_livro.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: formData.toString()
        });

        if (!response.ok) throw new Error('Erro na comunicação com o servidor.');

        const data = await response.json();

        if (data.status === 'success') {
          showMessage(data.message, 'success');
        } else {
          showMessage(data.message || 'Erro desconhecido.', 'error');
        }
      } catch (error) {
        showMessage(error.message || 'Erro ao salvar o livro.', 'error');
      } finally {
        button.disabled = false;
        button.textContent = 'Salvar Livro';
      }
    }
  })();
</script>

</body>
</html>

