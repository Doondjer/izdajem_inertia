<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
                    [
                        'title' => 'Brisanje korisničkih podataka',
                        'meta_title' => 'Brisanje korisničkih podataka',
                        'slug' => 'brisanje-korisnickih-podataka',
                        'classes' => '',
                        'size' => 'small',
                        'content' => '
                            <div>
                                <h2>Instrukcije za brisanje korisničkih podataka</h2>
                                <p>Poslednja izmena: Jun 06, 2021</p>
                                <p>Ukoliko želite da obrišemo vaše podatke pošaljite nam mail na <a href="mailto:application@izdajem.rs">application@izdajem.rs</a>, sa jasno navedenim zahtevom i razumno dovoljno podataka da možemo da potvrdimo da ste to vi!</p>
                                <p>Potrudićemo sa da podatke obrišemo u što kraćem vremenskom roku</p>
                                <p>
                                    Vaš,
                                    </p><p>Izdajem.rs tim.</p>
                                <p></p>
                            </div>
                        '
                    ],
                    [
                        'title' => 'Politika privatnosti',
                        'meta_title' => 'Politika privatnosti',
                        'slug' => 'politika-privatnosti',
                        'classes' => '',
                        'size' => 'small',
                        'content' => '
                            <div>
                                <h2>Privacy Policy</h2>
                                <p>Last updated: June 06, 2021</p>
                                <p>This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information when You use the Service and tells You about Your privacy rights and how the law protects You.</p>
                                <p>We use Your Personal data to provide and improve the Service. By using the Service, You agree to the collection and use of information in accordance with this Privacy Policy.</p>
                                <h2>Interpretation and Definitions</h2>
                                <h3>Interpretation</h3>
                                <p>The words of which the initial letter is capitalized have meanings defined under the following conditions. The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</p>
                                <h3>Definitions</h3>
                                <p>For the purposes of this Privacy Policy:</p>
                                <ul>
                                    <li>
                                        <p><strong>Account</strong> means a unique account created for You to access our Service or parts of our Service.</p>
                                    </li>
                                    <li>
                                        <p><strong>Company</strong> (referred to as either "the Company", "We", "Us" or "Our" in this Agreement) refers to Izdajem.rs.</p>
                                    </li>
                                    <li>
                                        <p><strong>Cookies</strong> are small files that are placed on Your computer, mobile device or any other device by a website, containing the details of Your browsing history on that website among its many uses.</p>
                                    </li>
                                    <li>
                                        <p><strong>Country</strong> refers to:  Serbia</p>
                                    </li>
                                    <li>
                                        <p><strong>Device</strong> means any device that can access the Service such as a computer, a cellphone or a digital tablet.</p>
                                    </li>
                                    <li>
                                        <p><strong>Personal Data</strong> is any information that relates to an identified or identifiable individual.</p>
                                    </li>
                                    <li>
                                        <p><strong>Service</strong> refers to the Website.</p>
                                    </li>
                                    <li>
                                        <p><strong>Service Provider</strong> means any natural or legal person who processes the data on behalf of the Company. It refers to third-party companies or individuals employed by the Company to facilitate the Service, to provide the Service on behalf of the Company, to perform services related to the Service or to assist the Company in analyzing how the Service is used.</p>
                                    </li>
                                    <li>
                                        <p><strong>Third-party Social Media Service</strong> refers to any website or any social network website through which a User can log in or create an account to use the Service.</p>
                                    </li>
                                    <li>
                                        <p><strong>Usage Data</strong> refers to data collected automatically, either generated by the use of the Service or from the Service infrastructure itself (for example, the duration of a page visit).</p>
                                    </li>
                                    <li>
                                        <p><strong>Website</strong> refers to Izdajem.rs, accessible from <a href="https://izdajem.rs" rel="external nofollow noopener" target="_blank">https://izdajem.rs</a></p>
                                    </li>
                                    <li>
                                        <p><strong>You</strong> means the individual accessing or using the Service, or the company, or other legal entity on behalf of which such individual is accessing or using the Service, as applicable.</p>
                                    </li>
                                </ul>
                                <h2>Collecting and Using Your Personal Data</h2>
                                <h3>Types of Data Collected</h3>
                                <h4>Personal Data</h4>
                                <p>While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to:</p>
                                <ul>
                                    <li>
                                        <p>Email address</p>
                                    </li>
                                    <li>
                                        <p>First name and last name</p>
                                    </li>
                                    <li>
                                        <p>Phone number</p>
                                    </li>
                                    <li>
                                        <p>Address, State, Province, ZIP/Postal code, City</p>
                                    </li>
                                    <li>
                                        <p>Usage Data</p>
                                    </li>
                                </ul>
                                <h4>Usage Data</h4>
                                <p>Usage Data is collected automatically when using the Service.</p>
                                <p>Usage Data may include information such as Your Device\'s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</p>
                                <p>When You access the Service by or through a mobile device, We may collect certain information automatically, including, but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP address of Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device identifiers and other diagnostic data.</p>
                                <p>We may also collect information that Your browser sends whenever You visit our Service or when You access the Service by or through a mobile device.</p>
                                <h4>Information from Third-Party Social Media Services</h4>
                                <p>The Company allows You to create an account and log in to use the Service through the following Third-party Social Media Services:</p>
                                <ul>
                                    <li>Google</li>
                                    <li>Facebook</li>
                                    <li>Twitter</li>
                                </ul>
                                <p>If You decide to register through or otherwise grant us access to a Third-Party Social Media Service, We may collect Personal data that is already associated with Your Third-Party Social Media Service\'s account, such as Your name, Your email address, Your activities or Your contact list associated with that account.</p>
                                <p>You may also have the option of sharing additional information with the Company through Your Third-Party Social Media Service\'s account. If You choose to provide such information and Personal Data, during registration or otherwise, You are giving the Company permission to use, share, and store it in a manner consistent with this Privacy Policy.</p>
                                <h4>Tracking Technologies and Cookies</h4>
                                <p>We use Cookies and similar tracking technologies to track the activity on Our Service and store certain information. Tracking technologies used are beacons, tags, and scripts to collect and track information and to improve and analyze Our Service. The technologies We use may include:</p>
                                <ul>
                                    <li><strong>Cookies or Browser Cookies.</strong> A cookie is a small file placed on Your Device. You can instruct Your browser to refuse all Cookies or to indicate when a Cookie is being sent. However, if You do not accept Cookies, You may not be able to use some parts of our Service. Unless you have adjusted Your browser setting so that it will refuse Cookies, our Service may use Cookies.</li>
                                    <li><strong>Flash Cookies.</strong> Certain features of our Service may use local stored objects (or Flash Cookies) to collect and store information about Your preferences or Your activity on our Service. Flash Cookies are not managed by the same browser settings as those used for Browser Cookies. For more information on how You can delete Flash Cookies, please read "Where can I change the settings for disabling, or deleting local shared objects?" available at <a href="https://helpx.adobe.com/flash-player/kb/disable-local-shared-objects-flash.html#main_Where_can_I_change_the_settings_for_disabling__or_deleting_local_shared_objects_" rel="external nofollow noopener" target="_blank">https://helpx.adobe.com/flash-player/kb/disable-local-shared-objects-flash.html#main_Where_can_I_change_the_settings_for_disabling__or_deleting_local_shared_objects_</a></li>
                                    <li><strong>Web Beacons.</strong> Certain sections of our Service and our emails may contain small electronic files known as web beacons (also referred to as clear gifs, pixel tags, and single-pixel gifs) that permit the Company, for example, to count users who have visited those pages or opened an email and for other related website statistics (for example, recording the popularity of a certain section and verifying system and server integrity).</li>
                                </ul>
                                <p>Cookies can be "Persistent" or "Session" Cookies. Persistent Cookies remain on Your personal computer or mobile device when You go offline, while Session Cookies are deleted as soon as You close Your web browser. Learn more about cookies: <a href="https://www.privacypolicies.com/blog/cookies/" target="_blank">What Are Cookies?</a>.</p>
                                <p>We use both Session and Persistent Cookies for the purposes set out below:</p>
                                <ul>
                                    <li>
                                        <p><strong>Necessary / Essential Cookies</strong></p>
                                        <p>Type: Session Cookies</p>
                                        <p>Administered by: Us</p>
                                        <p>Purpose: These Cookies are essential to provide You with services available through the Website and to enable You to use some of its features. They help to authenticate users and prevent fraudulent use of user accounts. Without these Cookies, the services that You have asked for cannot be provided, and We only use these Cookies to provide You with those services.</p>
                                    </li>
                                    <li>
                                        <p><strong>Cookies Policy / Notice Acceptance Cookies</strong></p>
                                        <p>Type: Persistent Cookies</p>
                                        <p>Administered by: Us</p>
                                        <p>Purpose: These Cookies identify if users have accepted the use of cookies on the Website.</p>
                                    </li>
                                    <li>
                                        <p><strong>Functionality Cookies</strong></p>
                                        <p>Type: Persistent Cookies</p>
                                        <p>Administered by: Us</p>
                                        <p>Purpose: These Cookies allow us to remember choices You make when You use the Website, such as remembering your login details or language preference. The purpose of these Cookies is to provide You with a more personal experience and to avoid You having to re-enter your preferences every time You use the Website.</p>
                                    </li>
                                </ul>
                                <p>For more information about the cookies we use and your choices regarding cookies, please visit our Cookies Policy or the Cookies section of our Privacy Policy.</p>
                                <h3>Use of Your Personal Data</h3>
                                <p>The Company may use Personal Data for the following purposes:</p>
                                <ul>
                                    <li>
                                        <p><strong>To provide and maintain our Service</strong>, including to monitor the usage of our Service.</p>
                                    </li>
                                    <li>
                                        <p><strong>To manage Your Account:</strong> to manage Your registration as a user of the Service. The Personal Data You provide can give You access to different functionalities of the Service that are available to You as a registered user.</p>
                                    </li>
                                    <li>
                                        <p><strong>For the performance of a contract:</strong> the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased or of any other contract with Us through the Service.</p>
                                    </li>
                                    <li>
                                        <p><strong>To contact You:</strong> To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication, such as a mobile application\'s push notifications regarding updates or informative communications related to the functionalities, products or contracted services, including the security updates, when necessary or reasonable for their implementation.</p>
                                    </li>
                                    <li>
                                        <p><strong>To provide You</strong> with news, special offers and general information about other goods, services and events which we offer that are similar to those that you have already purchased or enquired about unless You have opted not to receive such information.</p>
                                    </li>
                                    <li>
                                        <p><strong>To manage Your requests:</strong> To attend and manage Your requests to Us.</p>
                                    </li>
                                    <li>
                                        <p><strong>For business transfers:</strong> We may use Your information to evaluate or conduct a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Our assets, whether as a going concern or as part of bankruptcy, liquidation, or similar proceeding, in which Personal Data held by Us about our Service users is among the assets transferred.</p>
                                    </li>
                                    <li>
                                        <p><strong>For other purposes</strong>: We may use Your information for other purposes, such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and improve our Service, products, services, marketing and your experience.</p>
                                    </li>
                                </ul>
                                <p>We may share Your personal information in the following situations:</p>
                                <ul>
                                    <li><strong>With Service Providers:</strong> We may share Your personal information with Service Providers to monitor and analyze the use of our Service,  to contact You.</li>
                                    <li><strong>For business transfers:</strong> We may share or transfer Your personal information in connection with, or during negotiations of, any merger, sale of Company assets, financing, or acquisition of all or a portion of Our business to another company.</li>
                                    <li><strong>With Affiliates:</strong> We may share Your information with Our affiliates, in which case we will require those affiliates to honor this Privacy Policy. Affiliates include Our parent company and any other subsidiaries, joint venture partners or other companies that We control or that are under common control with Us.</li>
                                    <li><strong>With business partners:</strong> We may share Your information with Our business partners to offer You certain products, services or promotions.</li>
                                    <li><strong>With other users:</strong> when You share personal information or otherwise interact in the public areas with other users, such information may be viewed by all users and may be publicly distributed outside. If You interact with other users or register through a Third-Party Social Media Service, Your contacts on the Third-Party Social Media Service may see Your name, profile, pictures and description of Your activity. Similarly, other users will be able to view descriptions of Your activity, communicate with You and view Your profile.</li>
                                    <li><strong>With Your consent</strong>: We may disclose Your personal information for any other purpose with Your consent.</li>
                                </ul>
                                <h3>Retention of Your Personal Data</h3>
                                <p>The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our legal agreements and policies.</p>
                                <p>The Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of Our Service, or We are legally obligated to retain this data for longer time periods.</p>
                                <h3>Transfer of Your Personal Data</h3>
                                <p>Your information, including Personal Data, is processed at the Company\'s operating offices and in any other places where the parties involved in the processing are located. It means that this information may be transferred to — and maintained on — computers located outside of Your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from Your jurisdiction.</p>
                                <p>Your consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that transfer.</p>
                                <p>The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of Your data and other personal information.</p>
                                <h3>Disclosure of Your Personal Data</h3>
                                <h4>Business Transactions</h4>
                                <p>If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be transferred. We will provide notice before Your Personal Data is transferred and becomes subject to a different Privacy Policy.</p>
                                <h4>Law enforcement</h4>
                                <p>Under certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law or in response to valid requests by public authorities (e.g. a court or a government agency).</p>
                                <h4>Other legal requirements</h4>
                                <p>The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:</p>
                                <ul>
                                    <li>Comply with a legal obligation</li>
                                    <li>Protect and defend the rights or property of the Company</li>
                                    <li>Prevent or investigate possible wrongdoing in connection with the Service</li>
                                    <li>Protect the personal safety of Users of the Service or the public</li>
                                    <li>Protect against legal liability</li>
                                </ul>
                                <h2>Security of Your Personal Data</h2>
                                <p>The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.</p>
                                <h3>Your Legal Rights</h3>
                                <p>This is a breakdown of what each of your rights mean and the results you can expect when you enact them.</p>
                                <ul>
                                    <li>Right of Access to your personal data – This is usually called a ‘Subject Access Request’. You can request a copy of personal data to see what we hold about you and to check why &amp; how we are processing it and that we are processing it lawfully. We may be required to suitably redact (obscure) elements of the requested detail to protect the rights and personal data of other individuals.</li>
                                    <li>Right to rectification of your personal data – If you recognise any of the personal data we hold on you to be incorrect or incomplete you can request it to be corrected. In certain circumstances, we may require proof of accuracy of any new data being submitted.</li>
                                    <li>Right to erasure of your personal data – If you believe there is no fair reason for us to hold an element of your personal data, you can ask us to remove or delete this from our records, On occasion you may want to exercise this right on a successful objection to processing (see definition below). If for any reason, for example, to comply with a legal obligation, we cannot delete your personal data we will action your request as far as possible and provide to you a reason as to why we cannot fully comply with your request.</li>
                                    <li>Right to object to processing of your personal data – If we rely on legitimate interest as our legal basis for processing or the legitimate interest of another third party, you can object to our processing if you feel it impacts your fundamental rights and freedoms. We will reassess the legitimate grounds we have for processing your data and on occasion we may demonstrate that they are sufficient in overriding your rights and freedoms.</li>
                                    <li>
                                        Right to restrict processing of your personal data – You can ask us to temporarily pause the processing of your personal data in certain circumstances. For example:
                                        <ul>
                                            <li>If you have objected to our processing of your personal data, but we are assessing whether our legitimate grounds override your rights and freedoms.</li>
                                            <li>If you want to ensure that it is correct or complete before we continue to use it.</li>
                                            <li>If we are processing the data unlawfully but you do not want us to delete it.</li>
                                            <li>If you ask us to keep the data where we no longer need it, as you require it to establish, exercise or defend legal claims.</li>
                                            <li>Right to data portability – This applies to automated information originally received on the lawful basis of consent or performance of contract. You can ask for a copy of the related data and for it to be transferred to a third party of your choosing in a commonly used, machine readable format.</li>
                                        </ul>
                                    </li>
                                </ul>
                                <h3 id="user_rights">What are your rights?</h3>
                                <p>Upon occasion, you may be entitled to certain rights under data protection law. These are laid out below but a full breakdown of their meaning is available in the "Your Legal Rights" section. You can enact any of these rights by sending us an email to <a href="mailto:application@izdajem.rs">application@izdajem.rs</a>.</p>
                                <ul>
                                    <li>Right of Access to your personal data</li>
                                    <li>Right to rectification of your personal data</li>
                                    <li>Right to erasure of your personal data</li>
                                    <li>Right to object to processing of your personal data</li>
                                    <li>Right to restrict processing of your personal data</li>
                                    <li>Right to data portability</li>
                                </ul>
                                <p>There is no fee applicable to any of the above, however we may charge a fee or refuse your request if it is unfounded, excessive or repetitive.</p>
                                <p>We aim to respond to valid requests within one calendar month, however in certain circumstances it could take us longer. This may be because you have submitted a number of requests or your request is particularly complex. We will keep you updated with your request along the way if this is the case.</p>
                                <p>We may need to verify your identity and ensure your rights to the personal data we hold on occasion. We will always make sure our request is reasonable and in line with the information or right you are requesting. This ensures we are not sending the data to somebody who is not entitled to see it or acting upon a rights request that has not been legitimately made by the person who is entitled to it.</p>
                                 <h2>Children\'s Privacy</h2>
                                <p>Our Service does not address anyone under the age of 13. We do not knowingly collect personally identifiable information from anyone under the age of 13. If You are a parent or guardian and You are aware that Your child has provided Us with Personal Data, please contact Us. If We become aware that We have collected Personal Data from anyone under the age of 13 without verification of parental consent, We take steps to remove that information from Our servers.</p>
                                <p>If We need to rely on consent as a legal basis for processing Your information and Your country requires consent from a parent, We may require Your parent\'s consent before We collect and use that information.</p>
                                <h2>Links to Other Websites</h2>
                                <p>Our Service may contain links to other websites that are not operated by Us. If You click on a third party link, You will be directed to that third party\'s site. We strongly advise You to review the Privacy Policy of every site You visit.</p>
                                <p>We have no control over and assume no responsibility for the content, privacy policies or practices of any third party sites or services.</p>
                                <h2>Changes to this Privacy Policy</h2>
                                <p>We may update Our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy Policy on this page.</p>
                                <p>We will let You know via email and/or a prominent notice on Our Service, prior to the change becoming effective and update the "Last updated" date at the top of this Privacy Policy.</p>
                                <p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are effective when they are posted on this page.</p>
                                <h2>Contact Us</h2>
                                <p>If you have any questions about this Privacy Policy, You can contact us:</p>
                                <ul>
                                    <li>By email: <a href="mailto:application@izdajem.rs">application@izdajem.rs</a></li>
                                </ul>
                            </div>
                        '
                    ],
                    [
                        'title' => 'Uslovi Korišćenja',
                        'meta_title' => 'Uslovi Korišćenja',
                        'slug' => 'uslovi-koriscenja',
                        'classes' => '',
                        'size' => 'small',
                        'content' => '
                            <div>
                            <h3>Uvod</h3>

                            <p>
                                Izdajem.rs web portal se sastoji od različitih sadržaja koje održava
                                Izdajem.rs tim. Kada posećujete
                                ovu stranicu ili se koristite njome, pristajete na ovde navedena pravila.
                            </p>

                            <p>
                                Web stranicu Izdajem.rs možete da koristite pod uslovom da pristanete
                                na pravila, uslove i objave koje ona sadrži, bez modifikacija. Ako
                                koristite ovu stranicu, smatra se da se slažete sa svim pravilima,
                                uslovima i odredbama.
                            </p>

                            <p>
                                Izdajem.rs Beograd obrađuje podatke o ličnosti isključivo
                                na način i pod uslovima propisanim Pravilnikom o zaštiti podataka o
                                ličnosti koji je dostupan na adresi:
                                <a href="https://izdajem.rs/stranica/politika-privatnosti">https://izdajem.rs/stranica/politika-privatnosti</a>
                                i koji se smatra sastavnim delom ovih Uslova korišćenja.
                            </p>

                            <h3>Pravila korišćenja</h3>

                            <p>
                                Izdajem.rs redovno proverava i ažurira informacije objavljene na
                                stranici.
                            </p>
                            <p>
                                Izdajem.rs zadržava pravo na izmenu pravila, uslova i objava koje
                                regulišu njeno korišćenje.
                            </p>
                            <p>
                                Izdajem.rs nije odgovoran, niti garantuje da su informacije uvek
                                aktuelne, ispravne i/ili potpune.
                            </p>

                            <h3>REGISTRACIJA KORISNIKA</h3>
                            <p>
                                Prilikom registracije, korisnik je dužan uneti ime, prezime, e-mail i
                                postaviti šifru za pristup svom nalogu, ili se registrovati putem socijalnih mreža(Facebook, Google, Twitter...). Registrovan korisnik može uneti i
                                druge informacije kako bi poboljšao svoje korisničkog iskustvo, sve u
                                skladu sa Pravilnikom o zaštiti podataka o ličnosti.
                            </p>

                            <h3>VERIFIKACIJA KORISNIKA</h3>
                            <p>
                                Kako bi se verifikovao, registrovani korisnik je dužan uneti svoje lične
                                podatke definisane Pravilnikom o zaštiti podataka o ličnosti, a slučaju da
                                Izdajem.rs to od njega zahteva, korisnik je dužan verifikovati
                                svoj identitet slanjem fotografije lične karte (obe strane) ili pasoša
                                (strana sa ličnim podacima), sve u skladu sa odredbama Pravilnika o
                                zaštiti podataka o ličnosti
                            </p>

                            <h3>ZAKAZIVANJE GLEDANJA NEPOKRETNOSTI</h3>
                            <p>
                                Zakazivanje gledanja nepokretnosti oglašenih na stranici radi prodaje ili
                                davanja u zakup omogućeno je samo verifikovanim korisnicima.
                            </p>
                            <p>
                                Verifikacijom korisnik daje saglasnost da Izdajem.rs vlasnika
                                nepokretnosti čije gledanje korisnik zakazuje upozna sa ličnim podacima
                                korisnika iz prethodnog stava, čime ispunjava svoje obaveze prema vlasniku
                                iz Ugovora o posredovanju zaključenog s njim, sve u skladu sa Pravilnikom
                                o zaštiti podataka o ličnosti.
                            </p>

                            <h3>Veza sa drugim web portalima</h3>
                            <p>
                                Web stranica Izdajem.rs može da sadrži veze prema drugim Web
                                stranicama. Izdajem.rs nema kontrolu nad tim stranicama i nije
                                odgovorna za njihov sadržaj, uključujući bez ograničenja vezu prema nekoj
                                drugoj stranici, ili izmene i ažuriranje takve stranice.
                            </p>

                            <h3>Nezakonito ili zabranjeno korišćenje</h3>
                            <p>
                                Uslov za korišćenje Web stranice Izdajem.rs je Vaše jemstvo da nećete
                                upotrebljavati navedenu Web stranicu u svrhe koje su nezakonite ili
                                zabranjene navedenim pravilima ili uslovima. Nije dopušteno koristiti ovu
                                stranicu na način koji bi stranicu oštetio ili je onesposobio,
                                preopteretio ili ometao druge korisnike da se njome služe. Nije dopušteno
                                da uzimate ili pokušate da dobijete materijale ili informacije na način
                                koji nije omogućen ili ponuđen preko stranice.
                            </p>

                            <h3>Izuzeće od odgovornosti</h3>
                            <p>
                                Informacije, softver, proizvodi i usluge koje stranica sadrži ili koje su
                                dostupne kroz korišćenje stranice mogu da sadrže netačnosti ili
                                tipografske greške. Unesene informacije menjaju se periodično. Izdajem.rs
                                može unapređivati i/ili menjati Web stranicu u bilo kojem trenutku.
                                Sadržaj objavljen na Web stranici ne može biti temelj za donošenje ličnih,
                                pravnih ili finansijskih odluka.
                            </p>
                            <p>
                                Izdajem.rs ni u kojem slučaju ne može biti odgovoran za
                                neposrednu, posrednu, slučajnu, posledičnu ili neku drugu štetu koja
                                proizlazi ili je na bilo koji način povezana s korišćenjem stranice ili
                                njenim radom. Navedeno se primenjuje u najvećem mogućem obimu koji zakoni
                                dozvoljavaju.
                            </p>

                            <h3>Prekid / ograničenje pristupa</h3>
                            <p>
                                Izdajem.rs zadržava diskreciono pravo da prekine Vaš
                                pristup stranici i uslugama koje su uz nju vezane ili bilo kojem njihovom
                                delu u bilo koje vreme i bez prethodnog obaveštenja.
                            </p>
                            <br>
                            <p>Objavljeno dana 06.05.2021. godine</p>
                            <br>
                            <p>Izdajem.rs Beograd</p>
                </div>
                        '
                    ],
                ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
