 <script src="{{ url.path() }}assets/js/wzory.js"></script>           
<div id="main-content">
               
               <!-- <div class="path">
                    
                    <a href="#">strona główna</a> 
                    <p>&GT;&GT;</p>
                    <a href="#">wzory pism</a> 
                    
                </div>-->
                
                <div class="content-container col-lg-7 col-md-6 noright">
                    
                    <div class="col-lg-12 noleft">
                            
                        <div class="title-bar title-bar-wzory">
                                
                            <div class="content">
                                
                                <h1>SZYBKA WYSZUKIWARKA WZORÓW</h1>
                                
                                <form action="#" method="get">
                                    
                                    <input type="text" name="szukaj" required>
                                    <input type="submit" id="std_szukaj_wzorow" style="display: none;">
                                    <i id="szukaj_wzorow" class="fa fa-search"></i>
                                    
                                </form>
                                
                            </div>
                                
                        </div>
                            
                    </div>
                    
                    
                    <div class="wzory-box">
                        
                        <nav>
                            
                            <ul>
                                {% for item in tree %}
                                <li id="a-content-{{ loop. index }}" class="tactive"><a>{{ item['entry'] }} <i class="fa fa-minus"></i></a></li>

                                {% endfor %}
                                
                            </ul>
                            
                        </nav>
                        
                        <div class="content">
                            {% for item in tree %}
                            <div class="wzory">
                            
                                <ul id="box-content-kategorie">

                                    {% for sitem in item['childs'] %}
                                    <li id="a-content-kategorie-kategoria-{{ loop. index }}"><i class="fa fa-plus"></i>{{ sitem }} </li>
                                    
                                    <li class="dropdown-list" id="box-content-kategorie-kategoria-{{ loop.index}}">
                                        
                                        <ul>
                                            
                                            <li><a href="pobierz.php"><img src="./assets/img/wzory-pdf.png" alt="">Wniosek o rejestrację spółki komandytowo - akcyjnej</a></li>
                                            <li><a href="#"><img src="./assets/img/wzory-pdf.png" alt="">Wniosek o rejestrację spółki z ograniczoną odpowiedzialnością</a></li>
                                            
                                        </ul>
                                        
                                    </li>
                                    {% endfor %}
                 

                                </ul>
                                
              
                                
                            </div>
                             {% endfor %}
                            
                            
                            <div class="col-lg-12 noleft pagination-box">
                                <div class="col-lg-3 noleft pagination-prev">
                                    <i class="fa fa-caret-left"></i>
                                    <a class="prev">Poprzednia</a>
                                </div>
                                <div class="pagination-list col-lg-6 text-center hidden-md">
                                    <ul class="pagination">
                                        <li><a href="#">1</a></li>
                                        <li class="active"><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li><a href="#">5</a></li>
                                        <li><a href="#">....</a></li>
                                        <li><a href="#">25</a></li>
                                    </ul>
                                </div>
                                <div class="col-lg-3 pagination-next text-right">
                                    <a class="prev">Następna</a>
                                    <i class="fa fa-caret-right"></i>
                                </div>                            
                            </div>
                   
                        </div>
                        
                    </div>
                    
                </div>
                <aside class="sidebar-container col-lg-5 col-md-6 noleft">
                    
                    <div class="title-bar title-bar-search">
                                
                        <h2><strong>NIE ZNALAZŁEŚ DOKUMENTU?<br>NAPISZEMY GO DLA CIEBIE!</strong></h2>
                                
                    </div>
                    
                    
                    <div class="aside-contact-box">
                        
                        <form id="aside-contact-form" action="#" method="post">
                            
                            <h4>WYPEŁNIJ FORMULARZ!</h4>
                            
                            <div class="col-lg-12 col-md-12">
                                
                                <div class="form-group"><input type="text" name="imie_nazwisko" placeholder="Imię, nazwisko"></div>
                                <div class="form-group"><input type="email" name="email" placeholder="Adres e-mail"></div>
                                <div class="form-group"><input type="tel" name="tel" placeholder="Nr telefonu"></div>
                                
                            </div>
                            
                            <div class="col-lg-12 col-md-12">
                                
                                <textarea name="wiadomosc" placeholder="Treść wiadomości"></textarea>
                                
                                <a href="#">ZAMÓW DOKUMENT</a>
                                
                            </div>
                                                            
                        </form>
                        
                    </div>
                    
                    
                    <div id="ads-box-1"><h3>Miejsce na reklamę</h3></div>
                    
                </aside>
                
                
            </div>