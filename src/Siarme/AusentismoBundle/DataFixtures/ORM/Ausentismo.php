<?php

/*
 * (c) Ibañez Raul Adrian <ira.adrian@gmail.com>
 *
 * Este archivo pertenece a la aplicación de prueba SIARMe.
 */

namespace Siarme\AusentismoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Siarme\AusentismoBundle\Entity\DepartamentoRm;
use Siarme\AusentismoBundle\Entity\AreaRm;
use Siarme\AusentismoBundle\Entity\Agente;
use Siarme\AusentismoBundle\Entity\Articulo;
use Siarme\AusentismoBundle\Entity\Cargo;
use Siarme\AusentismoBundle\Entity\Departamento;
use Siarme\AusentismoBundle\Entity\Localidad;
use Siarme\AusentismoBundle\Entity\Organismo;
use Siarme\AusentismoBundle\Entity\Enfermedad;
/**
 * Fixtures de las entidades del Proyecto para
 * la Direccion de Reconocimientos Medicos.
 * Crea las entidades con las informacion de prueba muy realista.
 */
class Ausentismo extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function getOrder()
    {
        return 30;
    }

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
    
        // Crear 2 departamento_rm de prueba
        foreach (array('Autoseguro', 'Despacho') as $dptoRm) 
        {
            $departamentoRm = new DepartamentoRm();
            $departamentoRm->setDepartamentoRm($dptoRm);
            
            $manager->persist($departamentoRm);
        }

         $manager->flush();

        
         // Crear 3 areas para cada Departamento de Rec Medico


                $areaRm = new AreaRm();
                $areaRm->setAreaRm('Area Administrativa');   
                $areaRm->setRol('ROLE_ADMINISTRATIVO');            
                $manager->persist($areaRm);

                $areaRm = new AreaRm();
                $areaRm->setAreaRm('Auditoría Médica');
                $areaRm->setRol('ROLE_MEDICO');               
                $manager->persist($areaRm);

                $areaRm = new AreaRm();
                $areaRm->setAreaRm('Area Psiquiatrica');              
                $areaRm->setRol('ROLE_PSIQUIATRA');
                $manager->persist($areaRm);

                $areaRm = new AreaRm();
                $areaRm->setAreaRm('Area Mesa de Entrada');              
                $areaRm->setRol('ROLE_USUARIO');
                $manager->persist($areaRm);
        
                $manager->flush();
          

        // Crear los departametos de la Provincia de Catamarca.
        foreach (array('Ambato',
                     'Ancasti',
                     'Andalgalá',
                     'Antofagasta de la Sierra',
                     'Belén','Capayán', 
                     'Capital','El Alto',
                     'Fray Mamerto Esquiú',
                     'La Paz',
                     'Paclín',
                     'Pomán',
                     'Santa María',
                     'Santa Rosa',
                     'Tinogasta',
                     'Valle Viejo') as $dpto) 
        {
            $departamento = new Departamento();
            $departamento->setDepartamento($dpto);
            
            $manager->persist($departamento);
        }

         $manager->flush();

        
         // Crear las localidades de la Provincia de Catmarca

         $departamentos = $manager->getRepository('AusentismoBundle:Departamento')->findAll();
        
         $i=0;
         foreach ($departamentos as $dpto) {
            $i++;
            switch ($i) {
                case 1: $localidades = array('Chuchucaruana', 
                        'Colpes',
                        'El Bolsón',
                        'El Rodeo',
                        'Huaycama',
                        'La Puerta',
                        'Las Chacritas',
                        'Las Juntas',
                        'Los Castillos',
                        'Los Talas',
                        'Los Varela',
                        'Singuil');
                break;
                case 2: $localidades = array('Ancasti',
                        'Anquincila',
                        'La Candelaria',
                        'La Majada');
                break; 
                case 3: $localidades = array('Amanao', 
                         'Andalgalá',
                         'Chaquiago',
                         'Choya',
                         'El Alamito',
                         'El Lindero',
                         'El Potrero',
                         'La Aguada');
                break;
                case 4: $localidades = array('Antofagasta de la Sierra',
                        'Antofalla',
                        'El Peñón',
                        'Los Nacimientos');
                break;      
                case 5: $localidades = array('Barranca Larga',
                        'Belén','Cóndor Huasi',
                        'Corral Quemado',
                        'El Durazno',
                        'Farallón Negro',
                        'Hualfín',
                        'Jacipunco',
                        'La Puntilla',
                        'Las Juntas',
                        'Londres',
                        'Los Nacimientos',
                        'Puerta de Corral Quemado',
                        'Puerta de San José',
                        'Villa Vil');
                break;      
                case 6: $localidades = array('Adolfo E. Carranza',
                         'Balde de la Punta',
                         'Capayán','Chumbicha',
                         'Colonia del Valle',
                         'Colonia Nueva Coneta',
                         'Concepción','Coneta',
                         'Huillapima',
                         'Los Ángeles',
                         'Miraflores',
                         'San Martín',
                         'San Pablo',
                         'San Pedro');
                break;      
                case 7: $localidades = array('San Fernando del Valle de Catamarca',
                        'El Pantanillo'
                        );
                break;      
                case 8: $localidades = array('El Alto',
                        'Guayamba',
                        'Infanzón',
                        'Los Corrales',
                        'Tapso',
                        'Vilismán'
                        );
                break;      
                case 9: $localidades = array('Collagasta',
                        'Pomancillo Este',
                        'Pomancillo Oeste',
                        'San José',
                        'Villa Las Pirquitas'
                        );
                break;      
                case 10: $localidades = array('Casa de Piedra',
                        'El Aybal',
                        'El Bañado',
                        'El Divisadero',
                        'El Quimilo',
                        'Esquiú',
                        'Icaño',
                        'La Dorada',
                        'La Guardia',
                        'Las Esquinas',
                        'Las Palmitas',
                        'Quirós',
                        'Ramblones',
                        'Recreo',
                        'San Antonio'
                        );
                break;      
                case 11: $localidades = array('Amadores',
                        'El Rosario',
                        'La Bajada',
                        'La Higuera',
                        'La Merced',
                        'Las Lajas',
                        'La Viña',
                        'Monte Potrero',
                        'Palo Labrado',
                        'San Antonio',
                        'Villa de Balcozna'
                        );
                break;      
                case 12: $localidades = array('Apoyaco',
                        'Colana',
                        'Colpes',
                        'El Pajonal (Est. Pomán)',
                        'Joyango',
                        'Mutquín',
                        'Pomán',
                        'Rincón',
                        'San Miguel',
                        'Saujil',
                        'Siján'
                        );
                break;      
                case 13: $localidades = array('Andalhualá',
                        'Caspichango',
                        'Chañar Punco',
                        'El Cajón',
                        'El Desmonte',
                        'El Puesto',
                        'Famatanca',
                        'Fuerte Quemado',
                        'La Hoyada',
                        'La Loma',
                        'Las Mojarras',
                        'Loro Huasi',
                        'Punta de Balasto',
                        'San José',
                        'Santa María',
                        'Yapes'
                        );
                break;      
                case 14: $localidades = array('Alijilán',
                        'Bañado de Ovanta',
                        'Las Cañas',
                        'Lavalle',
                        'Los Altos',
                        'Manantiales',
                        'San Pedro'
                        );
                break;      
                case 15: $localidades = array('Anillaco',
                        'Antinaco',
                        'Banda de Lucero',
                        'Cerro Negro',
                        'Copacabana',
                        'Cordobita',
                        'Costa de Reyes',
                        'El Pueblito',
                        'El Puesto',
                        'El Salado',
                        'Fiambalá',
                        'Los Balverdis',
                        'Medanitos',
                        'Palo Blanco',
                        'Punta del Agua',
                        'Saujil',
                        'Tatón',
                        'Tinogasta'
                        );
                break;      
                case 16: $localidades = array('El Portezuelo',
                        'Huaycama',
                        'Las Tejas',
                        'San Isidro',
                        'Santa Cruz'
                        );
                break;                  
            }
            foreach ( $localidades as $l) {
                $localidad = New Localidad();
                $localidad->setLocalidad($l);
                $localidad->setDepartamento($dpto);
                $manager->persist($localidad);
            }
        }
        $manager->flush();

        // Crear las localidades de la Provincia de Catmarca
        $articulos = array(
                        '20ED',
                        '32',
                        '25D',
                        '25E',
                        '28',
                        '38',
                        '23'
                         );
        $descripciones = array(
                        'Art. 20° L.T. (EXCEPCION)- Dcto 1092/15',
                        'Art. 32 C.F. - Dcto. 1875/94',
                        'Art. 25° C.F. - Dcto 1092/15',
                        'Art. 25° L.T. (EXCEPCION) - Dcto. 1875/94',
                        'Art. 28° A.T. - Dcto. 1875/94',
                        'Art. 38° A.F. - Dcto. 1875/94',
                        'Art. 23° C.T. - Dcto. 1875/94'
                        );
        $j=count($articulos);
        for ($i=0; $i < $j; $i++) { 
            $articulo = New Articulo();
            $articulo->setCodigoArticulo($articulos[$i]);
            $articulo->setDescripcion($descripciones[$i]);
            $manager->persist($articulo);
        }

        $manager->flush();


        //Crear Agentes publicos  de Prueba y sus localidades
        $localidades = $manager->getRepository('AusentismoBundle:Localidad')->findAll();

        //Entregar  de Localidad aleatoria para cada agente        
        $localidad = $localidades[array_rand($localidades)];

        for ($i=0; $i < 100; $i++) { 
                $agente = New Agente();
                $agente->setApellidoNombre($this->getApellidos().' '.$this->getNombre());
                $cuiles= array(20,27);
                $dni= rand(15000000,32000000);
                $agente->setDni($dni);
                $agente->setCuil(sprintf('%s',$cuiles[array_rand($cuiles)].$dni.rand(0,9)));
                $agente->setDomicilio($this->getDireccion());
                $agente->setFechaAltaLaboral(new \DateTime('now - '.rand(365, 11000).' days'));
                $agente->setFechaNacimiento(new \DateTime('now - '.rand(7300, 20000).' days'));
                $agente->setLocalidad($localidad);
                $manager->persist($agente);
        }
        $manager->flush();

        //  Crear los Organismos Publicos de Prueba
        $organismos = array(
                        array('Direccion Provincial de Recursos Humanos ','SR. RESPONSABLE1'),
                        array('Direccion de Despacho Ministerio de Educacion Cs. y T.','SR. REPONSABLE2'),
                        array('Direccion Provincial de Reconocimientos Médicos','SR. RESPONSABLE3'),
                        array('Direccion de Provincial Recursos Humanos-Minist. de Educ. Cs. y T.','SR. REPONSABLE4'),
                        array('Asistencia Sanitaria ','SR. REPONSABLE5'),
                        array('Policía de la Provincia','SR. REPONSABLE6'),
                        array('Servicio Penitenciario Provincial ','SR. REPONSABLE7'),
                        array('Direccion Provincial de Educacion Privada y Municipal','SR. REPONSABLE8'),
                        array('Ministerio de Salud','SR. REPONSABLE9')
                     );

        $j=count($organismos);
        for ($i=0; $i < $j; $i++) { 
            $o = $organismos[$i];
            $organismo = New Organismo();
            $organismo->setOrganismo($o[0]);
            $organismo->setResponsable($o[1]);
            $manager->persist($organismo);
        }

        $manager->flush();


        //Crear los Cargos de los Agentes con sus repectivos lugares de trabajo
        $organismos = $manager->getRepository('AusentismoBundle:Organismo')->findAll();
        $agentes = $manager->getRepository('AusentismoBundle:Agente')->findAll();
        $cargos = array(
                        array('Administrativo','Permanente'),
                        array('Servicios Generales','Contratado'),
                        array('Maestro de Grado','Titular'),
                        array('Maestro de Grado','Suplente'),
                        array('Profesor','Titular'),
                        array('Auxiliar Administrativo','Contratado'),
                        array('Enfermero','Permanente'),
                        array('Medico','Contratado'),
                        array('Abogado','Permanente')
                    );

        foreach ($agentes as $agente) { 
                $o = $organismos[array_rand($organismos)];
                $c = $cargos[array_rand($cargos)];
                $cargo = New Cargo();
                $cargo->setOrganismo($o);
                $cargo->setAgente($agente);
                $cargo->setFuncion($c[0]);
                $cargo->setRevista($c[1]);
                $manager->persist($cargo);
        }

        $manager->flush();

        // Crear enfermedades y sus codigos 

        $enfermedades = array( array('A1','INSUFICIENCIA CORONARIA (ANGOR PECTORIS)','A'),
                    array('A10','OTRAS ENFERMEDADES DEL APARATO CIRCULATORIO','A'),
                    array('A11','PRE Y POST OPERATORIO C.V.','A'),
                    array('A2','ISQUEMIA O INFARTO DE MIOCARDIO','A'),
                    array('A3','AFECCIONES VALVULARES','A'),
                    array('A4','ENFERMEDAD HIPERTENSIVA','A'),
                    array('A5','ACCIDENTE CEREBRO-VASCULAR AGUDO','A'),
                    array('A6','ENFERMEDADES DE LAS ARTERIAS,ARTERIOLAS,CAPILARES','A'),
                    array('A7','ENFERMEDADES DE LAS VENAS (FLEBITIS,VARICES)','A'),
                    array('A8','INSUFICIENCIA CIRCULAR CENTRAL','A'),
                    array('A9','INSUFICIENCIA PERIFERICA','A'),
                    array('ART60','DONACION DE SANGRE','A'),
                    array('B1','ENFERMEDADES DE LOS DIENTES,ENCIAS Y MAXILARES','B'),
                    array('B10','SINDROME COLEDOCIANO','B'),
                    array('B11','DIARREAS AGUDAS CON/SIN DESHIDRATACION','B'),
                    array('B12','PANCREATITIS','B'),
                    array('B13','COLICO INTESTINAL','B'),
                    array('B14','OTRAS ENFERMEDADES DE RECTO Y/O ANO','B'),
                    array('B15','POST-OPERATORIO ABDOMINAL','B'),
                    array('B2','GASTRITIS,DUODENITIS,ESOFAGITIS','B'),
                    array('B3','ULCERA GASTRO DUODENAL','B'),
                    array('B4','HEMORRAGIA DIGESTIVA ALTA O BAJA','B'),
                    array('B5','HERNIAS Y ABSTRUCCION INTESTINAL','B'),
                    array('B6','INSUFICIENCIA HEPATICA','B'),
                    array('B7','HEPATITIS','B'),
                    array('B8','COLICO BILIAR','B'),
                    array('C1','GLOMERULO NEFRITIS AGUDA','C'),
                    array('C10','INSUFICIENCIA RENAL CRONICA-TRANP.RENAL','C'),
                    array('C11','OTRAS ENFERMEDADES DE LOS ORG.GENITALES MASC.','C'),
                    array('C13','ANEXITIS','C'),
                    array('C14','POST-OPERATORIO','C'),
                    array('C15','PROLAPSO UTERO-VAGINAL','C'),
                    array('C16','OTRAS ENFERMEDADES DE LOS ORG.GENITALES FEMEN.','C'),
                    array('C2','PIELO NEFRITIS','C'),
                    array('C3','COLICO RENAL','C'),
                    array('C4','OTRAS NEFRITIS Y NEFROSIS','C'),
                    array('C5','HIPERTROFIA DE LA PROSTATA','C'),
                    array('C6','CISTITIS','C'),
                    array('C7','ESTRECHEZ URETRAL','C'),
                    array('C8','OTRAS ENFERMEDADES DEL APARATO URINARIO','C'),
                    array('C9','HIDROCELE, VARICOCELE Y FIMOSIS','C'),
                    array('D1','AMENAZA DE ABORTO','D'),
                    array('D10','OTRAS CAUSAS DE MORBILIDAD Y MORTALIDAD PERINATAL','D'),
                    array('D11','ESTIMULACION TEMPRANA','D'),
                    array('D2','METRORRAGIAS Y HEMORRAGIAS DEL PARTO Y PUERPEIO','D'),
                    array('D3','SEPSIS DEL PARTO','D'),
                    array('D4','TOXEMIAS DEL EMBARAZO Y DEL PUERPERIO','D'),
                    array('D5','EMBARAZO','D'),
                    array('D6','POST-PARTO','D'),
                    array('D7','ALTERACIONES DEL RECIEN NACIDO','D'),
                    array('D8','OTRAS COMPLICACIONES DEL EMBARAZO,PARTO Y PUERPERI','D'),
                    array('D9','AFECCIONES DE LA PLACENTA Y DEL CORDON UMBILICAL','D'),
                    array('E1','MIOPIA,HIPERMETROPIA,ESTRABISMO','E'),
                    array('E2','CATARATA UNI O BILATERAL','E'),
                    array('E3','POST-OPERATORIO','E'),
                    array('E4','DESPRENDIMIENTO DE RETINA','E'),
                    array('E5','ENFERMEDADES INFLAMATORIAS DEL OJO','E'),
                    array('E6','OTRAS ENFERMEDADES DEL OJO (C.EXTRAÑOS,GLAUCOMA)','E'),
                    array('E7','OTITIS MEDIA Y SUS COMPLICACIONES','E'),
                    array('E8','OTRAS ENFERMEDADES DEL OIDO','E'),
                    array('E9','OTRAS ENFERMEDADES DE LOS ORG.DE LOS SENTIDOS','E'),
                    array('F1','ARTRITIS REUMATOIDEA','F'),
                    array('F10','FRACTURA MIEMBRO INFERIOR','F'),
                    array('F11','POST-OPERATORIO','F'),
                    array('F2','ARTROSIS','F'),
                    array('F3','LUMBOCIATRALGIA','F'),
                    array('F4','CERVICOBRAQUIALGIA','F'),
                    array('F5','OTRAS ENFERMEDADES DE LOS HUESOS','F'),
                    array('F6','LUXACIONES,ESGUINCES Y OTRAS ALTER.MUSCULARES','F'),
                    array('F7','DISCOPATIAS CON O SIN NEURALGIAS','F'),
                    array('F8','OTRAS ENFERM.DEL SIST.OSTEOMUSCULAR Y DEL TEJ.CONJ','F'),
                    array('F9','FRACTURA MIEMBRO SUPERIOR','F'),
                    array('G1','INFECCIONES RESPIRATORIAS AGUDAS','G'),
                    array('G2','AMIGDALITIS - EPISTAXI','G'),
                    array('G3','GRIPE','G'),
                    array('G4','NEUMONIA','G'),
                    array('G5','OTRAS NEUMONIAS','G'),
                    array('G6','BRONQUITIS CRONICA,ENFISEMA Y ASMA','G'),
                    array('G7','ENFERMEDADES ALERGICAS','G'),
                    array('G8','POST-OPERATORIO','G'),
                    array('G9','OTRAS ENFERM.DEL APARATO RESPIRATORIO','G'),
                    array('H1','HIPOTIROIDISMO','H'),
                    array('H2','HIPERTIROIDISMO','H'),
                    array('H3','OTRAS ENFERMEDADES DE LA GLANDULA TIROIDES','H'),
                    array('H4','DIABETES','H'),
                    array('H5','AVITAMINOSIS Y OTRAS ENFERM. CARENCIALES','H'),
                    array('H6','ENFERMEDADES DE LA NUTRICION Y DEL METABOLISMO','H'),
                    array('H7','OTRAS ENFERMEDADES DE LAS GLANDULAS ENDOCRINAS','H'),
                    array('H8','POST-OPERATORIO','H'),
                    array('I1','ANEMIAS','I'),
                    array('I2','LEUCEMIA','I'),
                    array('I3','LINFOMA','I'),
                    array('I4','LINFO-GRANULOMA (ENFERM.DE HODKING)','I'),
                    array('I5','LINFOSARCOMA','I'),
                    array('I6','ERITROBLASTOSIS','I'),
                    array('I7','OTRAS ENFERM.DE LA SANGRE Y DE LOS ORG.HEMATOPOYET','I'),
                    array('I8','DONACION DE SANGRE','I'),
                    array('J1','FIEBRE TIFOIDEA, PARATIFOIDEA Y OTRAS SALMONELLOSIS','J'),
                    array('J10','COQUELUCHE','J'),
                    array('J11','ESTREPTOCOCIAS','J'),
                    array('J12','TETANOS','J'),
                    array('J13','SEPTICEMIAS','J'),
                    array('J14','OTRAS ENFERMEDADES BACTERIANAS','J'),
                    array('J15','POLIOMIELITIS AGUDA','J'),
                    array('J16','SECUELA DE POLIOMIELITIS','J'),
                    array( 'J17','VARICELA','J'),
                    array('J18','VIRUELA','J'),
                    array('J19','SARAMPION','J'),
                    array('J2','MENINGITIS','J'),
                    array('J20','RUBEOLA','J'),
                    array('J23','FIEBRE HEMORRAGICA (MAL DE LOS RASTROJOS)','J'),
                    array('J24','RABIA','J'),
                    array('J25','PAROTIDITIS EPIDEMICA','J'),
                    array('J26','OTRAS VIROSIS','J'),
                    array('J27','ENFERMEDAD DE CHAGAS-MAZA','J'),
                    array('J28','SIFILIS CONGENITA','J'),
                    array('J29','OTRAS FORMAS DE SIFILIS','J'),
                    array('J30','GONORREA','J'),
                    array('J31','HIDATOSIS','J'),
                    array('J32','AMEBIASIS','J'),
                    array('J33','ANQUILOSTOMIASIS','J'),
                    array('J35','OTRAS ENFERM.INFECCIOSAS O PARASIT.NO CLASIF.','J'),
                    array('J4','ENTERITIS,ENTEROCOLITIS Y OTRAS ENFERM.DIARREICAS','J'),
                    array('J5','TUBERCULOSIS PULMONAR','J'),
                    array('J6','TUBERCULOSIS EN OTRAS LOCALIZACIONES','J'),
                    array('J7','BRUCELOSIS','J'),
                    array('J8','LEPRA','J'),
                    array('J9','DIFTERIA','J'),
                    array('K1','DERMITIS,DERMATOMICOSIS,ETC.','K'),
                    array('K2','OTRAS ENFERM.DE LA PIEL.ABCESO.LUPUS ERITEMATOSO','K'),
                    array('L1','PSICOSIS MANIACO-DEPRESIVA','L'),
                    array('L10','ESCLOROSIS EN PLACAS O MULTIPLES-ESCLEROSIS','L'),
                    array('L11','ESCLEROSIS LATERAL AMIOTROFICAS','L'),
                    array('L12','EPILEPSIAS','L'),
                    array('L13','OTRAS ENFERMEDADES DEL SISTEMA NERVIOSO CENTRAL','L'),
                    array('L14','NEURALGIAS Y NEURITIS','L'),
                    array('L15','CEFALEA - MIGRAÑA','L'),
                    array('L2','ESQUIZOFRENIA','L'),
                    array('L3','OTRAS PSICOSIS','L'),
                    array('L4','NEUROSIS Y PSICOPATIAS','L'),
                    array('L5','ESTADOS DEPRESIVOS','L'),
                    array('L6','ALCOHOLISMO','L'),
                    array('L7','DROGADICCION','L'),
                    array('L8','OLIGOFRENIAS','L'),
                    array('L9','ENFERMEDADES HEREDITARIAS O FAMIL.DEL S.N.C','L'),
                    array('M2','ANOMALIAS CONGENITAS DEL CORAZON','M'),
                    array('M3','FISURA DE PALADAR','M'),
                    array('M4','LABIO LEPORINO','M'),
                    array('M5','OTRAS ANOMALIAS CONGENITAS','M'),
                    array('N1','HERIDAS.EXCORIACIONES','N'),
                    array('N2','OTROS ACCIDENTES DE TRANSPORTE','N'),
                    array('N3','ENVENENAMIENTOS.INTOXICACIONES.','N'),
                    array('N4','QUEMADURAS','N'),
                    array('N6','LESIONES TRAUMATICAS EN GENERAL','N'),
                    array('O1','TUMOR DE CAVIDAD BUCAL Y FARINGE','O'),
                    array('O10','TUMOR DE LA MAMA','O'),
                    array('O11','TUMOR DE UTERO','O'),
                    array('O12','TUMOR DE OVARIO','O'),
                    array('O13','TUMOR DE LA PROSTATA','O'),
                    array('O14','TUMOR DE OTRAS LOCALIZACIONES','O'),
                    array('O15','TUMORES BENIGNOS Y TUMORES DE NAT.NO ESPECIF.','O'),
                    array('O16','QUISTES DE CUALQUIER NAT.(SINOVIAL,SACROCOXIGEO)','O'),
                    array('O2','TUMOR DE ESOFAGO','O'),
                    array('O3','TUMOR DE ESTOMAGO','O'),
                    array('O4','TUMOR DE COLON Y RECTO','O'),
                    array('O5','TUMOR DE TIROIDES','O'),
                    array('O6','TUMOR DE LARINGE','O'),
                    array('O7','TUMOR DE BRONQUIOS YO PULMON','O'),
                    array('O8','TUMOR DE LOS HUESOS','O'),
                    array('O9','TUMOR DE LA PIEL','O'),
                    array('P1','SENILIDAD SIN MENCION DE PSICOSIS','P'),
                    array('P2','SINTOMAS DE ESTADOS MORBOSOS MAL DEFINIDOS','P'),
                    array('Q1','EPICONDILITIS','Q'),
                    array('Q10','NODULOS DE LAS CUERDAS VOCALES','Q'),
                    array('Q11','DERMATISTIS ECZEMATIFORME AG.O CRONICA','Q'),
                    array('Q12','RINITIS ALEG.RECIDIVANTE','Q'),
                    array('Q13','HEPATITIS POR VIRUS A','Q'),
                    array('Q14','HEPATITIS POR VIRUS B Y C','Q'),
                    array('Q15','HEPATITIS CRONICA','Q'),
                    array('Q16','CIRROSIS POST-HEPATITIS B-C','Q'),
                    array('Q17','T.B.C.','Q'),
                    array('Q18','H.I.V.','Q'),
                    array('Q19','HERPES SIMPLE','Q'),
                    array('Q2','EPITROCLEITIS','Q'),
                    array('Q20','ANEMIAS-RADIODERMITIS-LEUCEMIA-ETC.','Q'),
                    array('Q21','ACCIDENTE IN ITINERE','Q'),
                    array('Q22','ACCIDENTES DE TRABAJO','Q'),
                    array('Q3','HIGROMAS','Q'),
                    array('Q4','SINDROME CERVICO-BRAQUIAL','Q'),
                    array('Q5','TENDINITIS Y TENOSINOVITIS DE LOS TEND.DE LA MANO','Q'),
                    array('Q6','SINDROME DEL TUNEL CARPIANO','Q'),
                    array('Q7','SINDROME DE GUYON','Q'),
                    array('Q8','DISFONIA','Q'),
                    array('Q9','DISFONIA PERSISTENTE','Q')
                );
        foreach ($enfermedades as $e) {
                    $enfermedad = New Enfermedad();
                    $enfermedad->setCodigoEnfermedad($e[0]);
                    $enfermedad->setEnfermedad($e[1]);
                    $enfermedad->setGrupo($e[2]);
                    $manager->persist($enfermedad);
        }
        $manager->flush();



  }
   /**
     * Generador aleatorio de nombres de personas.
     * Aproximadamente genera un 50% de hombres y un 50% de mujeres.
     *
     * @return string Nombre aleatorio generado para el usuario.
     */
    private function getNombre()
    {
        // Los nombres más comunes

        $hombres = array(
            'Antonio', 'José', 'Manuel', 'Francisco', 'Juan', 'David',
            'José Antonio', 'José Luis', 'Jesús', 'Javier', 'Francisco Javier',
            'Carlos', 'Daniel', 'Miguel', 'Rafael', 'Pedro', 'José Manuel',
            'Ángel', 'Alejandro', 'Miguel Ángel', 'José María', 'Fernando',
            'Luis', 'Sergio', 'Pablo', 'Jorge', 'Alberto'
        );
        $mujeres = array(
            'María Carmen', 'María', 'Carmen', 'Josefa', 'Isabel', 'Ana María',
            'María Dolores', 'María Pilar', 'María Teresa', 'Ana', 'Francisca',
            'Laura', 'Antonia', 'Dolores', 'María Angeles', 'Cristina', 'Marta',
            'María José', 'María Isabel', 'Pilar', 'María Luisa', 'Concepción',
            'Lucía', 'Mercedes', 'Manuela', 'Elena', 'Rosa María'
        );

        if (rand() % 2) {
            return $hombres[array_rand($hombres)];
        } else {
            return $mujeres[array_rand($mujeres)];
        }
    }

    /**
     * Generador aleatorio de apellidos de personas.
     *
     * @return string Apellido aleatorio generado para el usuario.
     */
    private function getApellidos()
    {
        // Los apellidos mas comunes

        $apellidos = array(
            'García', 'González', 'Rodríguez', 'Fernández', 'López', 'Martínez',
            'Sánchez', 'Pérez', 'Gómez', 'Martín', 'Jiménez', 'Ruiz',
            'Hernández', 'Díaz', 'Moreno', 'Álvarez', 'Muñoz', 'Romero',
            'Alonso', 'Gutiérrez', 'Navarro', 'Torres', 'Domínguez', 'Vázquez',
            'Ramos', 'Guzman', 'Ramírez', 'Serrano', 'Blanco', 'Suárez', 'Molina',
            'Morales', 'Ortega', 'Delgado', 'Castro', 'Ortíz', 'Rubio', 'Moya',
            'Ibañez', 'Aguero', 'Nuñez', 'Medina', 'Garrido'
        );

        return $apellidos[array_rand($apellidos)].' '.$apellidos[array_rand($apellidos)];
    }

    /**
     * Generador aleatorio de direcciones .
     *
     * @return string         Dirección aleatoria generada para la el Usuario.
     */
    private function getDireccion()
    {
        $prefijos = array('Calle', 'Avenida', 'Plaza');
        $nombres = array(
            'Lorem', 'Ipsum', 'Sitamet', 'Consectetur', 'Adipiscing',
            'Necsapien', 'Tincidunt', 'Facilisis', 'Nulla', 'Scelerisque',
            'Blandit', 'Ligula', 'Eget', 'Hendrerit', 'Malesuada', 'Enimsit'
        );

        return $prefijos[array_rand($prefijos)].' '.$nombres[array_rand($nombres)].', N°'.rand(1, 1000);
    }

    /**
     * Generador aleatorio de Numeros de Telefonos 
     *
     * @return string Código postal aleatorio generado para la el Usuario.
     */
    private function getTelefono()
    {
        return sprintf('%03s%46s', 383, rand(500000,700000));
    }
}