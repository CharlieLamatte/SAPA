import 'package:expandable/expandable.dart';
import 'package:flutter/material.dart';
import 'package:flutter_application_3/Screens/Components/maNavDrawer.dart';
import 'package:flutter_application_3/Screens/Components/monAppBar.dart';

class Emargement extends StatefulWidget {

  const Emargement({Key? key, }) : super(key: key);

  @override
  State<Emargement> createState() => _EmargementState();
}

class _EmargementState extends State<Emargement> {

  String? margingGroup1;
  String? margingGroup2;
  String? margingGroup3;
  String? margingGroup4;

  @override
  Widget build(BuildContext context) {
    // TODO: implement build
    return
      SafeArea(
        child: Scaffold(
          // App bar ///////////////////////////////////////////////////////////
          appBar: MonAppBar(
            myTitle: "Émargement de la séance",
          ),
          drawer: const MyNavDrawer(),

          body:

          Container(
            padding: const EdgeInsets.only(
                left: 25.0,
                top: 15.0,
                right: 25.0,
                bottom: 15.0
            ),
            child:
            Column(
              children: [
                Table(
                  children: [
                    // première ligne d'en-tête
                    TableRow(children: [
                      const Text("Bénéficiaire", style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15)),
                      const Text("Présence", style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15)),
                      const Text("Absence", style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15)),
                      const Text("Excusé", style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15))
                    ]),

                    // liste des bénéficiaire à construire automatiquement
                    TableRow(children: [
                      TableCell(
                        verticalAlignment: TableCellVerticalAlignment.middle,
                        child: Text("Eugène CURASSO"),
                      ),
                      RadioListTile(
                        value: "presence",
                        groupValue: margingGroup1,
                        onChanged: (value){
                          setState(() {
                            margingGroup1 = value.toString();
                          });
                        },
                      ),

                      RadioListTile(
                        value: "absence",
                        groupValue: margingGroup1,
                        onChanged: (value){
                          setState(() {
                            margingGroup1 = value.toString();
                          });
                        },
                      ),

                      RadioListTile(
                        value: "excuse",
                        groupValue: margingGroup1,
                        onChanged: (value){
                          setState(() {
                            margingGroup1 = value.toString();
                          });
                        },
                      ),


                    ]),


                    TableRow(children: [
                      TableCell(
                        verticalAlignment: TableCellVerticalAlignment.middle,
                        child: Text("Léo WYATT"),
                      ),
                      RadioListTile(
                        value: "presence",
                        groupValue: margingGroup2,
                        onChanged: (value){
                          setState(() {
                            margingGroup2 = value.toString();
                          });
                        },
                      ),

                      RadioListTile(
                        value: "absence",
                        groupValue: margingGroup2,
                        onChanged: (value){
                          setState(() {
                            margingGroup2 = value.toString();
                          });
                        },
                      ),

                      RadioListTile(
                        value: "excuse",
                        groupValue: margingGroup2,
                        onChanged: (value){
                          setState(() {
                            margingGroup2 = value.toString();
                          });
                        },
                      ),


                    ]),


                    TableRow(children: [
                      TableCell(
                        verticalAlignment: TableCellVerticalAlignment.middle,
                        child: Text("Jaques FRANC"),
                      ),
                      RadioListTile(
                        value: "presence",
                        groupValue: margingGroup3,
                        onChanged: (value){
                          setState(() {
                            margingGroup3 = value.toString();
                          });
                        },
                      ),

                      RadioListTile(
                        value: "absence",
                        groupValue: margingGroup3,
                        onChanged: (value){
                          setState(() {
                            margingGroup3 = value.toString();
                          });
                        },
                      ),

                      RadioListTile(
                        value: "excuse",
                        groupValue: margingGroup3,
                        onChanged: (value){
                          setState(() {
                            margingGroup3 = value.toString();
                          });
                        },
                      ),
                    ]),
                  ],

                ),


                // boutons en bas de page
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,

                  children: [
                    Container(
                        decoration: BoxDecoration(
                          borderRadius: const BorderRadius.all(
                              Radius.circular(100.0)
                          ),
                          color: Theme
                              .of(context)
                              .primaryColorLight,
                        ),
                        width: 115.0,
                        height: 40.0,
                        child:
                        ElevatedButton(
                          style: ButtonStyle(
                            shape: MaterialStateProperty.all<
                                RoundedRectangleBorder>(
                                RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(
                                      10.0),
                                )
                            ),
                            backgroundColor: MaterialStateProperty.all<
                                Color>(
                                Theme
                                    .of(context)
                                    .primaryColorLight
                            ),
                          ),

                          onPressed: () { },
                          child: Row(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                const SizedBox(
                                  width: 5.0,
                                ),
                                Text(
                                  'Retour',
                                  style: TextStyle(
                                    color: Theme
                                        .of(context)
                                        .primaryColor,
                                  ),
                                ),
                              ]
                          ),
                        )
                    ),

                    const SizedBox(
                      width: 40.0,
                    ),

                    Container(
                        decoration: BoxDecoration(
                          borderRadius: const BorderRadius.all(
                              Radius.circular(100.0)
                          ),
                          color: Theme
                              .of(context)
                              .primaryColorLight,
                        ),
                        width: 115.0,
                        height: 40.0,
                        child:
                        ElevatedButton(
                          style: ButtonStyle(
                            shape: MaterialStateProperty.all<
                                RoundedRectangleBorder>(
                                RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(
                                      10.0),
                                )
                            ),
                            backgroundColor: MaterialStateProperty.all<
                                Color>(
                                Theme
                                    .of(context)
                                    .primaryColorLight
                            ),
                          ),

                          onPressed: () { },
                          child: Row(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                const SizedBox(
                                  width: 5.0,
                                ),
                                Text(
                                  'Emarger',
                                  style: TextStyle(
                                    color: Theme
                                        .of(context)
                                        .primaryColor,
                                  ),
                                ),
                              ]
                          ),
                        )
                    ),

                  ],
                ),


                const SizedBox(
                  height: 20.0,
                ),

                Row(
                  mainAxisAlignment: MainAxisAlignment.center,

                  children: [
                    Container(
                        decoration: BoxDecoration(
                          borderRadius: const BorderRadius.all(
                              Radius.circular(100.0)
                          ),
                          color: Theme
                              .of(context)
                              .primaryColorLight,
                        ),
                        width: 200.0,
                        height: 40.0,
                        child:
                        ElevatedButton(
                          style: ButtonStyle(
                            shape: MaterialStateProperty.all<
                                RoundedRectangleBorder>(
                                RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(
                                      10.0),
                                )
                            ),
                            backgroundColor: MaterialStateProperty.all<
                                Color>(
                                Theme
                                    .of(context)
                                    .primaryColorLight
                            ),
                          ),

                          onPressed: () { },
                          child: Row(
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                const SizedBox(
                                  width: 5.0,
                                ),
                                Text(
                                  'Valider la séance',
                                  style: TextStyle(
                                    color: Theme
                                        .of(context)
                                        .primaryColor,
                                  ),
                                ),
                              ]
                          ),
                        )
                    ),
                  ],
                ),



              ],
            ),
          ),
        ),

      );

  }

}