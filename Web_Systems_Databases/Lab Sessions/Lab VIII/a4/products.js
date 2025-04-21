const xhr = new XMLHttpRequest();
    xhr.open('GET', 'recommendations.json', true);
    xhr.responseType = 'json';

    xhr.onload = () => {
      if(xhr.status === 200){
        const jsonData = xhr.response;
        const parentDiv = document.getElementById('recommendations');
        // console.log(`JSON data: ${jsonData}`);
        
        jsonData.forEach((obj, idx) => {
          if(idx < 10){
            let title = document.createElement('h4');
            let body = document.createElement('p');
            let article = document.createElement('article');
            let br = document.createElement('br');
            let div = document.createElement('div');
            

            article.className = `article-${idx} jumbotron jumbotron-fluid`;
            div.className = 'container';
            body.className = 'lead';
            title.className = 'display-6'
            article.style.backgroundColor = '#c5e3ec';
            article.style.borderRadius = '15px';
            article.style.padding = '20px 15px';
            article.style.margin = '15px 0px'

            title.textContent = obj.id + '-' + obj.title;
            body.textContent = obj.body;
            div.appendChild(title);
            div.appendChild(body);
            
            article.appendChild(div);

            parentDiv.appendChild(article);
          } else {
            stop;
          }
      });


      } else {
        console.error(`Error loading json: ${xhr.status}`);
      }
    }

    const loadData = (ev) => {
      ev.preventDefault();
      xhr.send();
    }

