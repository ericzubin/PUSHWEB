package com.embeddedlapps.subastas_cliente;

import com.parse.Parse;
import com.parse.ParseInstallation;
import com.parse.PushService;

public class Application extends android.app.Application {

  public Application() {
  }

  @Override
  public void onCreate() {
    super.onCreate();

	// Initialize the Parse SDK.
	Parse.initialize(this, "bFJ9w2UrSrhYMMmIDQUGvSzkVLcAXesZcskm2gYw", "pxxLXWNZ8VnttreFZxqNbOoB09MMRBXbYUgMRPUN");

	// Specify an Activity to handle all pushes by default.
	PushService.setDefaultPushCallback(this, MisSubastas.class);
	// Save the current Installation to Parse.
	//ParseInstallation.getCurrentInstallation().saveInBackground();
  }
}