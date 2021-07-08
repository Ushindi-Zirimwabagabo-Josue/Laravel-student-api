<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function getAllStudents()
    {
        return response()->json(Student::orderBy('created_at', 'DESC')->get(), 200);
    }

    public function createStudent(Request $request)
    {
        $newStudent = new Student;
        $newStudent->name = $request->name;
        $newStudent->course = $request->course;

        $newStudent->save();

        return response()->json(['message' => 'Student created successfully', 'data' => $newStudent], 201);
    }

    public function getStudent($id)
    {
        if (Student::where('id', $id)->exists()) {
            $student = Student::where('id', $id)->get();
            return response()->json(['data' => $student]);
        } 
        else {
            return response()->json([
              "message" => "Student not found"
            ], 404);
          }
    }

    public function updateStudent(Request $request, $id)
    {
        $existingStudent = Student::find($id);
        if($existingStudent){
            $existingStudent->name = $request->name;
            $existingStudent->course = $request->course;
            $existingStudent->save();
            return response()->json(['message' => 'Student updated successfully', 'data' => $existingStudent], 200);
        }
        else{
            return response()->json([
                "message" => "Student not found"
              ], 404);
        }
    }

    public function deleteStudent($id)
    {
        $studentToDelete = Student::find($id);
        if($studentToDelete){
            $studentToDelete->delete();
            return response()->json(['message' => 'Student deleted successfully'], 202);
        }
        else{
            return response()->json([
                "message" => "Student with id $id was not found"
              ], 404);
        }
    }
}
